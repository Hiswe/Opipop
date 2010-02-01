<?php

    DB::update('
		UPDATE `category`
        SET `label` = "' . $_POST['label'] . '"
        WHERE `id` = "' . $_POST['id'] . '"
	');

