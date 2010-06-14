<?php

    header('Content-Type: application/json; charset=utf-8');
    header("Cache-Control: no-cache");

    set_time_limit(120);
    ini_set("memory_limit",'512M');

    if (isset($_FILES) && isset($_FILES['Filedata']))
    {
        echo '2';
        $size = filesize($_FILES['Filedata']['tmp_name']);
        $stat = stat($_FILES['Filedata']['tmp_name']);

        if ($size[0] <= 2048 && $size[1] <= 2048 && $stat['size'] <= 2000 * 1024)
        {
            $extention = strtolower(preg_replace('#.+\.([a-zA-Z]+)$#isU', '$1', $_FILES['Filedata']['name']));
            $original  = Conf::get('ROOT_DIR'). 'media/question/original/' . $_POST['id'] . '.' . $extention;

            move_uploaded_file($_FILES['Filedata']['tmp_name'], $original);

            $sizeMedium = explode('x', Conf::get('QUESTION_MEDIUM_SIZE'));

            Tool::redimage($original, Conf::get('ROOT_DIR') . 'media/question/315x145/' . $_POST['id'] . '.jpg', $sizeMedium[0], (isset ($sizeMedium[1])) ? $sizeMedium[1] : false, true);

            Tool::redimage($original, Conf::get('ROOT_DIR') . 'backoffice/image/preview/question_' . $_POST['id'] . '.jpg', 120, 55, true);

            echo '1';
        }
    }
        echo '3';

