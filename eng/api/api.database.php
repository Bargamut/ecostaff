<?php
class Database {
    function db_connect($server, $username, $password) {
        $db_index = mysql_connect($server, $username, $password) or die('Ошибка подключения к базе данных!');
        return $db_index;
    }
    function db_close($db_index) {
        mysql_close($db_index);
    }
    function db_select_db($database, $db_index) {
        mysql_select_db($database, $db_index) or die('Не удалось найти нужную базу данных!');
    }
    function db_query() {
        $args = func_get_args();
        if (func_num_args() >= 1) {
            $q = array_shift($args); // Запрос
            if (count($args) == 1) {
                $p = array_shift($args); // Подставляемые параметры
            }


            // Если есть подставляемые параметры
            if (isset($p)){
                if (!is_array($p)) {
                    $p = array($p);
                }
                $q = $this->quoteSet($q);

                foreach($p as $k => $v) {
                    $p[$k] = $this->strFormat($v);
                }

                $q = vsprintf($q, $p);
            }

            if (!$q) { return false; }

            $r = mysql_query($q) or die(mysql_error());
            $r = $this->db_make_result($r, $q);
        } else {
            $r = 'Нет нужных данных!';
        }
        return $r;
    }
    /**
     * Фкнкция квотирования
     * @param $q - запрос
     * @return mixed - отредактированный запрос
     */
    private function quoteSet($q) {
        $q = preg_replace_callback(
            '/(%?)(%[sd])(:\w+)?(%?)/i',
            function($m) {
                $r = ($m[2] == '%s' || ($m[2] == '%d' && $m[3] == ':like')) ?
                    "'" . $m[1].$m[1].$m[2].$m[4].$m[4] . "'"
                    :   $m[1].$m[1].$m[2].$m[4].$m[4];

                return $r;
            },
            $q);
        return $q;
    }
    /**
     * Функция форматирования строчных ресурсов
     * @param $str - строка
     * @return string - форматированная строка
     */
    private function strFormat($str) {
        $str = htmlspecialchars(mysql_real_escape_string($str));
        return $str;
    }

    /**
     * Функция компоновки результата запроса
     * @param $r - результат запроса
     * @param $q - запрос
     * @return array - возвращаемый массив
     */
    private function db_make_result($r, $q) {
        $result = array();
        if (preg_match('/^SELECT/i', $q)) {
            if (mysql_num_rows($r) == 1) {
                $result[] = mysql_fetch_assoc($r);
            } else if (mysql_num_rows($r) > 1) {
                while ($row = mysql_fetch_assoc($r)) {
                    $result[] = $row;
                }
            }
        }
        return $result;
    }
}
?>