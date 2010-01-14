<?php

    require_once '../../inc/conf.default.php';
    require_once '../../inc/conf.local.php';
    require_once '../../inc/setup.php';

    header("Cache-Control: no-cache");

    $db->update('UPDATE `category` SET `status`=(`status`+1)%2 WHERE `id`="' . $_POST['id'] . '"');

