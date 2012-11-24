<?php
/**
 * User: Bargamut
 * Date: 23.11.12
 * Time: 19:56
 */

include('../top.php');

if (!empty($_POST['mode'])) {
    if (!empty($_POST['cid'])) {
        $client_params = array(
            $_POST['fio'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['skype'],
            $_POST['note']
        );

        switch ($_POST['mode']) {
            case 'select':
                $client = $DB->db_query('SELECT * FROM clients WHERE `id`=%d ORDER BY `id` LIMIT 1', $_POST['cid']);
                echo json_encode($client[0]);
                break;
            case 'insert':
                $DB->db_query('INSERT INTO clients (`fio`, `phone`, `email`, `skype`, `note`) VALUES (%s, %s, %s, %s, %s)', $client_params);
                $client[0]['id'] = mysql_insert_id();
                $client = $DB->db_query('SELECT * FROM clients WHERE `id`=%d ORDER BY `id` LIMIT 1', $client[0]['id']);
                echo json_encode($client[0]);
                break;
            case 'update':
                $client_params[] = $_POST['cid'];
                $DB->db_query('UPDATE clients SET `fio`=%s, `phone`=%s, `email`=%s, `skype`=%s, `note`=%s WHERE `id`=%d LIMIT 1', $client_params);
                $client = $DB->db_query('SELECT * FROM clients WHERE `id`=%d', $_POST['cid']);
                echo json_encode($client[0]);
                break;
            case 'delete':
                $DB->db_query('DELETE FROM clients WHERE `id`=%d LiMIT 1', $_POST['cid']);
                echo json_encode(array('ok'));
                break;
            default: break;
        }
    } else if (!empty($_POST['gid'])) {
        $group_params = array(
            $_POST['name'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['skype'],
            $_POST['note']
        );
        switch ($_POST['mode']) {
            case 'select':
                $group = $DB->db_query('SELECT * FROM clients_groups WHERE `id`=%d ORDER BY `id` LIMIT 1', $_POST['gid']);
                echo json_encode($group[0]);
                break;
            case 'insert':
                $DB->db_query('INSERT INTO clients_groups (`name`, `phone`, `email`, `skype`, `note`) VALUES (%s, %s, %s, %s, %s)', $group_params);
                $group[0]['id'] = mysql_insert_id();
                $group = $DB->db_query('SELECT * FROM clients_groups WHERE `id`=%d ORDER BY `id` LIMIT 1', $group[0]['id']);
                echo json_encode($group[0]);
                break;
            case 'update':
                $group_params[] = $_POST['gid'];
                $DB->db_query('UPDATE clients_groups SET `name`=%s, `phone`=%s, `email`=%s, `skype`=%s, `note`=%s WHERE `id`=%d LIMIT 1', $group_params);
                $group = $DB->db_query('SELECT * FROM clients_groups WHERE `id`=%d', $_POST['gid']);
                echo json_encode($group[0]);
                break;
            case 'delete':
                $DB->db_query('DELETE FROM clients_groups WHERE `id`=%d LiMIT 1', $_POST['gid']);
                echo json_encode(array('ok'));
                break;
            default: break;
        }
    }
}