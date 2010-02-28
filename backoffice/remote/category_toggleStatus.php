<?php

    header("Cache-Control: no-cache");

    DB::update('
        UPDATE `category`
        SET `status`=(`status`+1)%2
        WHERE `id`="' . $_POST['id'] . '"
    ');

