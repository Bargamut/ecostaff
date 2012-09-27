<?php
// TODO: сделать фильтрацию значений против SQL Injection
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
        if (func_num_args() >= 2) {
            $q = array_shift($args);
            $p = array_shift($args);

            $q = $this->quoteSet($q);

            foreach($p as $k => $v) {
                $p[$k] = $this->strFormat($v);
            }

            $q = vsprintf($q, $p);
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
            function($m) { return $this->PregCallback($m); },
            $q);
        return $q;
    }
    private function PregCallback($m) {
        $r = ($m[2] == '%s' || ($m[2] == '%d' && $m[3] == ':like')) ?
                "'" . $m[1].$m[1].$m[2].$m[4].$m[4] . "'"
            :   $m[1].$m[1].$m[2].$m[4].$m[4];

        return $r;
    }

    /**
     * Функция форматирования строчных ресурсов
     * @param $str - строка
     * @return string - форматированная строка
     */
    private function strFormat($str) {
        return htmlspecialchars(mysql_real_escape_string($str));
    }

    private function db_make_result($r, $q) {
        $result = array();
        if (preg_match('/^SELECT/i', $q)) {
            if (mysql_num_rows($r) == 1) {
                return mysql_fetch_assoc($r);
            } else {
                while ($row = mysql_fetch_assoc($r)) {
                    $result[] = $row;
                }
                return $result;
            }
        } else {
            return $r;
        }
    }
//    function db_delete() {}
//    function db_search() {}
}
?>