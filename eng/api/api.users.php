<?php
/**
 * User: Bargamut
 * Date: 15.07.12
 * Time: 22:46
 */

// TODO: вывести модуль Users на другой уровень абстракции - если возможно, сделать из него 1, способный порождать свои объекты (Users, Pages и т.д.)
// TODO: преобразование дат
class Users {
    private $DB = null;
    public function __construct($DB) {
        $this->DB = $DB;
    }
    /**
     * Регистрация пользователя
     * @param $subm - сабмит
     * @param $post - массив данных пользователя
     */
    function registration($subm, $post) {
        if (!empty($subm) && $this->registrationCorrect($post)) {
            $mail = $post['rEmail'];
            $salt = $this->generateRandString(250);
            $date_reg = date('Y-m-d H:i:s');
            $fio = array(
                'firstname'     => $post['rName'],
                'lastname'      => $post['rLName'],
                'fathername'    => $post['rFName']
            );
            $password = hash('sha512', hash('sha512', $post['rPass']).$salt);
            $token = hash('sha512', uniqid(rand(), 1));
            $filial_id = $post['rFilial'];

            $forUserSite = array($mail, $password, $salt, $date_reg, $date_reg, $token, $filial_id);
            $forUserBio = array($fio['firstname'], $fio['lastname'], $fio['fathername']);

            $this->DB->db_query('INSERT INTO users_site (`email`, `password`, `salt`, `date_reg`, `date_lastvisit`, `uid`, `filial`) VALUES (%s, %s, %s, %s, %s, %s, %d)', $forUserSite);
            $this->DB->db_query('INSERT INTO users_bio (`firstname`, `lastname`, `fathername`) VALUES (%s, %s, %s)', $forUserBio);
//            if (mysql_query($db_query) or die(mysql_error())) {
//                return $this->auth($subm, $post['rEmail'], $post['rPass']);
//            }
        } else {
//            header('Location: http://'.$_SERVER['SERVER_NAME']);
        }
    }

    /**
     * Авторизация пользователя
     */
    function auth($subm, $mail, $pass) {
        // Если был сабмит авторизации и все данные введены верно
        if (!empty($subm) && $this->authCorrect($mail, $pass)) {
            $user = $this->getUserInfo($mail);
            $user['UNAME'] = $user['lastname'].' '.$user['firstname'].' '.$user['fathername'];

            // Устанавливаем coockie с данными пользователя
            setcookie ("UID",   $user['uid'],   time() + 50000, '/');
            setcookie ("email", $user['email'], time() + 50000, '/');

            // Меняем дату последнего посещения
            $this->DB->db_query('UPDATE users_site SET `date_lastvisit`=%s WHERE `email`=%s LIMIT 1', [date('Y-m-d H:i:s'), $mail]);
            // И перенаправляем на главную
            header('Location: http://'.$_SERVER['SERVER_NAME']);
        } else {
            // Перенаправляем на главную
            // header('Location: http://'.$_SERVER['SERVER_NAME']);
        }

        return $user;
    }

    /**
     * Выход
     */
    function logout() {
        setcookie ("UID", '', time() - 50000, '/');
        setcookie ("email", '', time() - 50000, '/');

        session_destroy();

        header('Location: http://'.$_SERVER['SERVER_NAME']);
    }

    /**
     * Проверка на авторизованность пользователя
     * @return bool
     */
    function already_login() {
        return (isset($_SESSION['USER']['uid']) || (isset($_COOKIE['UID']) && isset($_COOKIE['email'])));
    }

    /**
     * Функция проверки полномочий пользователя
     * @param $lvl
     * @param $userlvl
     * @return bool
     */
    function check_rights($needed, $current) {
        $res = false;

        $current    = $this->parseRights($current);
        $needed     = $this->parseRights($needed);

        foreach($needed as $nk => $nv) {
            foreach($current as $ck => $cv) {
                ($nk == $ck && preg_match('/['.$nv.']/', $cv)) ? $res = true : null;
            }
        }

        return $res;
    }

    function userTab($uname) {
        $res = file_get_contents(SITE_ROOT.'/tpl/userTab.html');
        $res = str_replace('{uname}',           $uname, $res);
        $res = str_replace('{AUTH_PROFILE}',    AUTH_PROFILE, $res);
        $res = str_replace('{AUTH_EXIT}',       AUTH_EXIT, $res);
        return $res;
    }

    function mAuthForm() {
        $res = file_get_contents(SITE_ROOT.'/tpl/mAuthForm.html');
        $res = str_replace('{AUTH_EMAIL}',          AUTH_EMAIL, $res);
        $res = str_replace('{AUTH_PASSWORD}',       AUTH_PASSWORD, $res);
        $res = str_replace('{AUTH_SUBMIT}',         AUTH_SUBMIT, $res);
        $res = str_replace('{AUTH_REGISTRATION}',   AUTH_REGISTRATION, $res);
        return $res;
    }

    /**
     * Функция данных пользователя
     * @param $mail
     * @return array
     */
    function userinfo($mail) { return $this->getUserInfo($mail); }

    /**
     * Функция данных профиля
     * @param string $mail E-Mail пользователя
     * @return array
     */
    function profile($mail) { return $this->getProfileInfo($mail); }

    /**
     * Функция данных профилей
     * @return array
     */
    function profiles() { return $this->getProfilesInfo(); }

    /**
     * Функция проверки UID на соответствие необходимому
     * @param $uid          - пользовательский UID
     * @param $needleUID    - необходимый UID
     * @return bool
     */
    function isyoUID($uid, $needleUID) {
        return ($uid == $needleUID);
    }

    /**
     * Фукция обновления данных
     */
    function updProfile($tbl, $post, $uid) {
        $sets = array();

        foreach($post as $k => $v) { $sets[] = '`'.$k.'`="'.$v.'"'; }
        $sets = implode(',', $sets);

        $result = $this->DB->db_query('SELECT `id` FROM users_site WHERE `uid`=%s LIMIT 1', $uid);

        mysql_query('UPDATE '.$tbl.' SET '.$sets.' WHERE `id`="'.$result['id'].'" LIMIT 1') or die(mysql_error());
        return true;
    }

    /**
     * Функция проверки пароля
     * @param $mail
     * @param $pass
     * @return bool
     */
    function check_pass($mail, $pass) {
        $result = '';
        // не меньше ли 5 символов длина пароля
        if (strlen($pass) >= 5) {
            $user = $this->DB->db_query('SELECT `password`, `salt` FROM users_site WHERE `email`=%s AND `block`="0" LIMIT 1', [$mail]);
            if (hash('sha512', hash('sha512', $pass).$user['salt']) != $user['password']) {
                    $result .= 'Невереная пара Логин/Пароль';
            }
        }
        return ($result == '');
    }

    /**
     * Функция проверки корректности введённых данных авторизации
     * @return bool
     */
    private function authCorrect($mail, $pass) {
        $result = '';

        if ($mail == "") $result .= 'Пустой E-Mail|';     // не пусто ли поле логина
        if ($pass == "") $result .= 'Пустой пароль';      // не пусто ли поле пароля
        // не меньше ли 5 символов длина пароля
        if (strlen($pass) < 5 || empty($pass)) $result .= 'pass < 5|';

        $user = $this->DB->db_query('SELECT `password`, `salt` FROM users_site WHERE `email`=%s AND `block`="0" LIMIT 1', [$mail]);

        // проверка на существование в БД такого же логина
        if (count($user) == 0) $result .= 'Такого пользователя нет';

        if (hash('sha512', hash('sha512', $pass).$user['salt']) != $user['password']) $result .= 'Невереная пара Логин/Пароль';

        return ($result == ''); // если выполнение функции дошло до этого места, возвращаем true
    }

    /**
     * Функция проверки корректности введённых данных регистрации
     * @return bool
     */
    private function registrationCorrect() {
        $result = '';

        if ($_POST['rEmail'] == "") $result = 'email|';                       // не пусто ли поле логина
        if ($_POST['rFilial'] == "") $result = 'filial|';                       // не пусто ли поле логина
        if ($_POST['rPass'] == "") $result = 'pass|';                        // не пусто ли поле пароля
        if ($_POST['rPass2'] == "") $result = 'pass2|';                       // не пусто ли поле подтверждения пароля
        if ($_POST['rLic'] != "ok") $result = 'lic|';                       // приняты ли правила
        if (!preg_match('/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/is', $_POST['rEmail'])) $result = 'preg_email|'; // соответствует ли поле e-mail регулярному выражению
//    if (!preg_match('/^([а-яА-a-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is'   , $_POST['rLName'])) return false;  // соответствует ли Фамилия регулярному выражению
//    if (!preg_match('/^([а-яА-a-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is'   , $_POST['rName'])) return false;   // соответствует ли Имя регулярному выражению
//    if (!preg_match('/^([а-яА-Яa-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is'  , $_POST['rFName'])) return false;  // соответствует ли Отчество регулярному выражению
        if (strlen($_POST['rPass']) < 5 && empty($_POST['rPass'])) $result = 'pass < 5|';               // не меньше ли 5 символов длина пароля
        if (hash('sha512', $_POST['rPass']) != hash('sha512', $_POST['rPass2'])) $result = 'not_confirm_pass|';    // равен ли пароль его подтверждению

        $rez = $this->DB->db_query('SELECT * FROM users_site WHERE `email`=%s LIMIT 1', [$_POST['rMail']]);
        if (count($rez) != 0) $result = 'already_exist|';                   // проверка на существование в БД такого же логина

        echo $result;
        return ($result == '');                                                    // если выполнение функции дошло до этого места, возвращаем true
    }

    /**
     * Функция запроса данных пользователя
     */
    private function getUserInfo($mail) {
        $us = $this->DB->db_query('SELECT `id`, `email`, `uid`, `date_reg`, `date_lastvisit`, `level`, `filial`, `block`, `block_reason` FROM users_site WHERE `email`=%s LIMIT 1', [$mail]);
        $ub = $this->DB->db_query('SELECT `firstname`, `lastname`, `fathername` FROM users_bio WHERE `id` = %d LIMIT 1', [$us['id']]);
        $ul = $this->DB->db_query('SELECT `rights`, `lvlname` FROM users_lvl WHERE `lvl` = %s LIMIT 1', [$us['level']]);

        $user = array_merge($us, $ub, $ul);
        return $user;
    }

    /**
     * Функция запроса данных профиля, кроме гостевого
     */
    private function getProfileInfo($mail) {
        $us = $this->DB->db_query('SELECT `id`, `email`, `uid`, `level`, `filial`, `block`, `block_reason` FROM users_site WHERE `email`=%s AND `level` != "G" LIMIT 1', [$mail]);
        $ub = $this->DB->db_query('SELECT `firstname`, `lastname`, `fathername`, `birthday` FROM users_bio WHERE `id`=%d LIMIT 1', [$us['id']]);
        $ul = $this->DB->db_query('SELECT `lvlname` FROM users_lvl WHERE `lvl`=%s LIMIT 1', [$us['level']]);

        $profile = array_merge($us, $ub, $ul);
        return $profile;
    }

    /**
     * Функция выбора профилей всех пользовтелей
     * @return array
     */
    private function getProfilesInfo() {
        $us = $this->DB->db_query('SELECT `id`, `block` FROM users_site ORDER BY `id`', ['']);
        $ub = $this->DB->db_query('SELECT `firstname`, `lastname`, `fathername` FROM users_bio ORDER BY `id`', ['']);

        $profiles = array();
        $profiles[$us['id']] = array_merge($us, $ub);
        unset($profiles[$us['id']]['id']);

        return $profiles;
    }

    /**
     * Функция разбора полномочий
     */
    private function parseRights($rights) {
        $r = array();

        $arr = explode(', ', $rights);
        foreach($arr as $k => $val) {
            $a = explode(':', $val);
            $r[$a[0]] = $a[1];
        }
        return $r;
    }

    /**
     * Функция генерации случайной строки
     * @param int $length
     * @return string
     */
    function generateRandString($length = 35){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789._:;';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, mt_rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}