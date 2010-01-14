<?php

    require_once '../../inc/conf.default.php';
    require_once '../../inc/conf.local.php';
    require_once '../../inc/setup.php';

    if ($_POST['shift'] != 0)
    {
        $rs = $db->select('SELECT `position` FROM `category` WHERE id="' . $_POST['id'] . '"');

        if ($rs['total'] != 0)
        {
            $currentPosition = $rs['data'][0]['position'];

            if ($_POST['shift'] > 0)
            {
                $db->update('UPDATE `category`
                    SET `position` = `position` - "' . $_POST['shift'] . '"
                    WHERE `position` = "' . ($currentPosition + $_POST['shift']) . '"');
                $db->update('UPDATE `category`
                    SET `position` = `position` + "' . $_POST['shift'] . '"
                    WHERE `id` = "' . $_POST['id'] . '"');
            }
            else
            {
                $db->update('UPDATE `category`
                    SET `position` = `position` + "' . abs($_POST['shift']) . '"
                    WHERE `position` = "' . ($currentPosition - abs($_POST['shift'])) . '"');
                $db->update('UPDATE `category`
                    SET `position` = `position` - "' . abs($_POST['shift']) . '"
                    WHERE `id` = "' . $_POST['id'] . '"');
            }
        }
    }

