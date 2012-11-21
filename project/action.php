<?php
/**
 * User: Bargamut
 * Date: 28.09.12
 * Time: 1:33
 */

include('../top.php');

// Если был submit формы
if (!empty($_POST['btnSubm']) || !empty($_POST['btnEdit']) || !empty($_POST['btnClose'])) {
    // Если закрываем проект
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

    // Если нет ошибок
    if (!array_key_exists('send', $SITE->err)) {
        // Определяем тип действия
        if (!empty($_POST['btnSubm'])) { $type = 'create'; }
        if (!empty($_POST['btnEdit'])) { $type = 'update'; }
        if (!empty($_POST['btnClose'])) { $type = 'close'; }

        switch ($type) {
            case 'create': // создаём проект
                if (empty($_POST['group'])) {
                    // если нет клиента с данным email - добавляем, есть - выбираем его
                    $client = $DB->db_query('SELECT `id` FROM clients WHERE `email`=%s', $_POST['email']);
                    if (count($client[0]) == 0) {
                        $client_params = array(
                            $_POST['fio'],
                            $_POST['phone'],
                            $_POST['email'],
                            $_POST['skype'],
                            $_POST['note']
                        );
                        $DB->db_query('INSERT INTO clients (`fio`, `phone`, `email`, `skype`, `note`) VALUES (%s, %s, %s, %s, %s)', $client_params);
                        $client[0]['id'] = mysql_insert_id();
                    }
                }

                // Если при создании проекта не вносилась сумма,
                // то в поле "при подписании" ставится 0
                if (!empty($_POST['pay'])) {
                    $pays = array_merge((array)$_POST['oldpays'], (array)$_POST['pay']);
                } else {
                    $_POST['pay'] = 0;
                    $pays = (array)$_POST['pay'];
                }

                // формируем массив данных для отправки в БД
                $proj_params = array(
                    $client[0]['id'],
                    $_POST['group'],
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
                    $ECON->payed($pays),
                    $_POST['manager'],
                    $SITE->dateFormat($_POST['date'], 'Y-m-d')
                );

                $query_fields = '`clientid`, `groupid`, `fid`, `number`, `hours`, `hours2`, `form`, `programm`, `payvariant`, `tid`, `wagerate`, `cost`, `payed`, `mid`, `date`';

                // отправляем запрос
                $DB->db_query('INSERT INTO projects (' . $query_fields . ') VALUES (%d, %d, %d, %d, %d, %d, %d, %s, %d, %d, %d, %d, %d, %d, %s)', $proj_params);

                // прописываем информацию о платежах и отчитанные часы
                $_POST['pid'] = mysql_insert_id();
                $ECON->makePay($_POST['pid'], $_POST['manager'], $_POST['pay'], $_POST['payvariant']);
                $ECON->countHours($_POST['pid'], $_POST['teacher'], $_POST['oldhours2'], $_POST['hours2'], $_POST['wagerate']);
                break;
            case 'update': // обновляем
                if (empty($_POST['group'])) {
                    // если клиента нет в базе - добавляем
                    $client = $DB->db_query('SELECT `id` FROM clients WHERE `email`=%s', $_POST['email']);
                    if (count($client[0]) == 0) {
                        $client_params = array(
                            $_POST['fio'],
                            $_POST['phone'],
                            $_POST['email'],
                            $_POST['skype'],
                            $_POST['note']
                        );
                        $DB->db_query('INSERT INTO clients (`fio`, `phone`, `email`, `skype`, `note`) VALUES (%s, %s, %s, %s, %s)', $client_params);
                        $client['id'] = mysql_insert_id();
                    } else { // иначе обновляем инфо о клиенте
                        $client_params = array(
                            $_POST['note'],
                            $client['id']
                        );
                        $DB->db_query('UPDATE clients SET `note` = %s WHERE `id` = %d LIMIT 1', $client_params);
                    }
                }

                // если был возврат, то присваиваем аналогичный статус
                if ($_POST['return'] > 0) { $_POST['status'] = 4; }

                // Если есть новый платёж, добавляем к старым
                $pays = (!empty($_POST['pay'])) ? array_merge((array)$_POST['oldpays'], (array)$_POST['pay']) : (array)$_POST['oldpays'];

                // формируем запрос в БД
                $proj_params = array(
                    $ECON->payed($pays),
                    $_POST['hours2'],
                    $_POST['programm'],
                    $_POST['teacher'],
                    $_POST['wagerate'],
                    $_POST['status'],
                    $_POST['return'],
                    $_POST['number']
                );
                $query_fields = '`payed`=%d, `hours2`=%d, `programm`=%s, `tid`=%d, `wagerate`=%d, `status`=%d, `return`=%d';

                $DB->db_query('UPDATE projects SET ' . $query_fields . ' WHERE `number`=%d', $proj_params);

                // прописываем информацию о платежах и отчитанных часах, если есть
                $ECON->makePay($_POST['pid'], $_POST['manager'], $_POST['pay'], $_POST['payvariant']);
                $ECON->countHours($_POST['pid'], $_POST['teacher'], $_POST['oldhours2'], $_POST['hours2'], $_POST['wagerate']);
                break;
            case 'close': // закрываем проект
                // Если есть новый платёж, добавляем его к старым
                $pays = (!empty($_POST['pay'])) ? array_merge((array)$_POST['oldpays'], (array)$_POST['pay']) : (array)$_POST['oldpays'];

                // формируем запрос в БД
                $proj_params = array(
                    $ECON->payed($pays),
                    $_POST['hours2'],
                    $_POST['programm'],
                    $_POST['teacher'],
                    $_POST['wagerate'],
                    4,
                    $_POST['return'],
                    $_POST['number']
                );
                $query_fields = '`payed`=%d, `hours2`=%d, `programm`=%s, `tid`=%d, `wagerate`=%d, `status`=%d, `return`=%d';

                $DB->db_query('UPDATE projects SET ' . $query_fields . ' WHERE `number`=%d', $proj_params);

                // прописываем информацию о платежах и отчитанных часах,если есть
                $ECON->makePay($_POST['pid'], $_POST['manager'], $_POST['pay'], $_POST['payvariant']);
                $ECON->countHours($_POST['pid'], $_POST['teacher'], $_POST['oldhours2'], $_POST['hours2'], $_POST['wagerate']);
                break;
            default: break;
        }
        // пернаправляем на страницу проекта
        header('Location: /project/?p=' . $_POST['pid']);
    } else { // выводим ошибки, если есть
        $r = '';
        foreach($SITE->err['send'] as $k => $v) { $r .= '<b>Ошибка!</b> Некорректное значение: ' . $v . '!<br />'; }
        echo $r;
    };
}