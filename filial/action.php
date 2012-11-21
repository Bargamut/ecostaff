<?php
/**
 * User: Bargamut
 * Date: 28.09.12
 * Time: 1:33
 */

include('../top.php');

// Если был submit формы
if (!empty($_POST['btnSubm']) || !empty($_POST['btnEdit']) || !empty($_POST['btnClose'])) {
    // Если нет ошибок
    if (!array_key_exists('send', $SITE->err)) {
        // Определяем тип действия
        if (!empty($_POST['btnSubm'])) { $type = 'create'; }
        if (!empty($_POST['btnEdit'])) { $type = 'update'; }
        if (!empty($_POST['btnClose'])) { $type = 'close'; }

        switch ($type) {
            case 'create': // создаём проект
                // если нет клиента с данным email - добавляем, есть - выбираем его
                $filial = $DB->db_query('SELECT `id` FROM filial WHERE `name` = %s', $_POST['filialName']);
                if (count($filial[0]) == 0) {
                    $DB->db_query('INSERT INTO filial (`name`) VALUES (%s)', $_POST['filialName']);
                }
                break;
            case 'update': // обновляем
                    $filial_params = array(
                        $_POST['filialName'],
                        $_POST['FID']
                    );
                    $DB->db_query('UPDATE filial SET `name` = %s WHERE `id` = %d LIMIT 1', $filial_params);
                break;
            case 'close': // закрываем проект
                break;
            default: break;
        }
        // пернаправляем на страницу проекта
        header('Location: /filial/');
    } else { // выводим ошибки, если есть
        $r = '';
        foreach($SITE->err['send'] as $k => $v) { $r .= '<b>Ошибка!</b> Некорректное значение: ' . $v . '!<br />'; }
        echo $r;
    };
}