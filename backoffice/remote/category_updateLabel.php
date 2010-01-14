<?php

    require_once '../../inc/conf.default.php';
    require_once '../../inc/conf.local.php';
    require_once '../../inc/setup.php';

    $db->update('UPDATE `category`
        SET `label` = "' . $_POST['label'] . '"
        WHERE `id` = "' . $_POST['id'] . '"');

