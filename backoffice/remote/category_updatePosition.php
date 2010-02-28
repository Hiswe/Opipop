<?php

    if ($_POST['shift'] != 0)
    {
        $rs = DB::select('
            SELECT `position`
            FROM `category`
            WHERE id="' . $_POST['id'] . '"
        ');

        if ($rs['total'] != 0)
        {
            $currentPosition = $rs['data'][0]['position'];

            if ($_POST['shift'] > 0)
            {
                DB::update('
                    UPDATE `category`
                    SET `position` = `position` - "' . $_POST['shift'] . '"
                    WHERE `position` = "' . ($currentPosition + $_POST['shift']) . '"
                ');
                DB::update('
                    UPDATE `category`
                    SET `position` = `position` + "' . $_POST['shift'] . '"
                    WHERE `id` = "' . $_POST['id'] . '"
                ');
            }
            else
            {
                DB::update('
                    UPDATE `category`
                    SET `position` = `position` + "' . abs($_POST['shift']) . '"
                    WHERE `position` = "' . ($currentPosition - abs($_POST['shift'])) . '"
                ');
                DB::update('
                    UPDATE `category`
                    SET `position` = `position` - "' . abs($_POST['shift']) . '"
                    WHERE `id` = "' . $_POST['id'] . '"
                ');
            }
        }
    }

