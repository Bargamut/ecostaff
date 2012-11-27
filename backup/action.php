<?php
/**
 * User: Bargamut
 * Date: 27.11.12
 * Time: 0:56
 */

include('../top.php');

if (!empty($POST['mode'])) {
    switch ($POST['mode']) {
        case 'make': $DB->makeDump(); break;
        case 'take':
            if (!empty($_POST['date'])) {
                $DB->takeDump($_POST['date']);
            }
            break;
        default: break;
    }
}

?>