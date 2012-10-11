<?php
/**
 * User: Bargamut
 * Date: 28.09.12
 * Time: 1:33
 */

include('../top.php');
echo '<pre>';
print_r($_POST);
echo '</pre>';

if (!empty($_POST['btnSubm']) || !empty($_POST['btnEdit']) || !empty($_POST['btnClose'])) {
    if (!empty($_POST['btnClose'])) {
        // Регулярные выражения для проверки данных
        $number_reg = '/^([0-9]{4})$/isu';
        $mail_reg   = '/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/isu';
        $date_reg   = '/^([0-9]{4}-[0-9]{2}-[0-9]{2})$/isu';
        $phone_reg  = '/^([\+\(\)\-0-9]{7,18})$/isu';

        $SITE->var2send_pm($_POST['number'],    $number_reg,    '№ договора');
        $SITE->var2send_pm($_POST['date'],      $date_reg,      'Дата заключения договора');
        $SITE->var2send_pm($_POST['email'],     $mail_reg,      'E-Mail');
        $SITE->var2send_pm($_POST['phone'],     $phone_reg,     'Телефон клиента');
    }

    if (!array_key_exists('send', $SITE->err)) {
        if (!empty($_POST['btnSubm'])) { $type = 'create'; }
        if (!empty($_POST['btnEdit'])) { $type = 'update'; }
        if (!empty($_POST['btnClose'])) { $type = 'close'; }
        switch ($type) {
            case 'create':
                $client = $DB->db_query('SELECT `id` FROM clients WHERE `fio`=%s', [$_POST['fio']]);
                if (count($client) == 0) {
                    $client_params = array(
                        $_POST['fio'],
                        $_POST['phone'],
                        $_POST['email'],
                        $_POST['skype'],
                        $_POST['note']
                    );
                    $DB->db_query('INSERT INTO clients (`fio`, `phone`, `email`, `skype`, `note`) VALUES (%s, %s, %s, %s, %s)', $client_params);
                    $client['id'] = mysql_insert_id();
                }

                $proj_params = array(
                    $client['id'],
                    $_POST['filial'],
                    $_POST['number'],
                    $_POST['hours'],
                    $_POST['hours2'],
                    $_POST['form'],
                    $_POST['programm'],
                    $_POST['payvariant'],
                    $_POST['teacher'],
                    $_POST['wagerate'],
                    $_POST['cost'],
                    $_POST['manager'],
                    $_POST['date'],
                    $_POST['etap1'],
                    $_POST['etap2'],
                    $_POST['etap3'],
                    $_POST['etap4']
                );
                echo '<pre>';
                print_r($proj_params);
                echo '</pre>';
                $query_fields = '`clientid`, `filial`, `number`, `hours`, `hours2`, `form`, `programm`, `payvariant`, `teacher`, `wagerate`, `cost`, `manager`, `date`, `etap1`, `etap2`, `etap3`, `etap4`';
                $DB->db_query('INSERT INTO projects (' . $query_fields . ') VALUES (%d, %d, %d, %d, %d, %d, %s, %d, %d, %d, %d, %d, %s, %d, %d, %d, %d)', $proj_params);
                break;
            case 'update':
                $client = $DB->db_query('SELECT `id` FROM clients WHERE `fio`=%s', [$_POST['fio']]);
                if (count($client) == 0) {
                    $client_params = array(
                        $_POST['fio'],
                        $_POST['phone'],
                        $_POST['email'],
                        $_POST['skype'],
                        $_POST['note']
                    );
                    $DB->db_query('INSERT INTO clients (`fio`, `phone`, `email`, `skype`, `note`) VALUES (%s, %s, %s, %s, %s)', $client_params);
                    $client['id'] = mysql_insert_id();
                } else {
                    $client_params = array(
                        $_POST['note'],
                        $client['id']
                    );
                    $DB->db_query('UPDATE clients SET `note`=%s WHERE `id`=%d LIMIT 1', $client_params);
                }

                if ($_POST['return'] > 0) { $_POST['status'] = 4; }
                $proj_params = array(
                    $_POST['hours2'],
                    $_POST['programm'],
                    $_POST['teacher'],
                    $_POST['wagerate'],
                    $_POST['etap1'],
                    $_POST['etap2'],
                    $_POST['etap3'],
                    $_POST['etap4'],
                    $_POST['status'],
                    $_POST['return'],
                    $_POST['number']
                );
                echo '<pre>';
                print_r($proj_params);
                echo '</pre>';
                $query_fields = '`hours2`=%d, `programm`=%s, `teacher`=%d, `wagerate`=%d, `etap1`=%d, `etap2`=%d, `etap3`=%d, `etap4`=%d, `status`=%d, `return`=%d';
                $DB->db_query('UPDATE projects SET ' . $query_fields . ' WHERE `number`=%s', $proj_params);
                break;
            case 'close':
                $DB->db_query('UPDATE projects SET `status`=%d WHERE `number`=%d', [4, $_POST['number']]);
                break;
            default: break;
        }
    } else {
        $r = '';
        foreach($SITE->err['send'] as $k => $v) { $r .= '<b>Ошибка!</b> Некорректное значение: ' . $v . '!<br />'; }
        echo $r;
    };

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}