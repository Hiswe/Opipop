<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

    if (!$_SESSION['user'][$_POST['id']] || !isOk($_POST['zip']) || !isOk($_POST['gender']) || !isOk($_POST['id']) || !isOk($_POST['login']))
    {
		header('Location: ' . ROOT_PATH);
        exit();
    }


    $db->update('UPDATE `user` SET
        `zip`="' . $_POST['zip'] . '",
        `male`="' . $_POST['gender'] . '"
        WHERE `id`="' . $_POST['id'] . '"');

	if (isset($_FILES) && isset($_FILES['avatar']))
	{
		$size = filesize($_FILES['avatar']['tmp_name']);
		$stat = stat($_FILES['avatar']['tmp_name']);

		if ($size[0] <= 1680 && $size[1] <= 1680 && $stat['size'] <= 450 * 1024)
		{
			$extention = strtolower(preg_replace ('#.+\.([a-zA-Z]+)$#isU', '$1', $_FILES['avatar']['name']));
			$original  = ROOT_DIR . 'media/avatar/original/' . $_POST['id'] . '.' . $extention;

			move_uploaded_file($_FILES['avatar']['tmp_name'], $original);

			$sizeSmall  = explode('x', AVATAR_SMALL_SIZE);
			$sizeMedium = explode('x', AVATAR_MEDIUM_SIZE);
			$sizeLarge  = explode('x', AVATAR_LARGE_SIZE);

			redimage($original, ROOT_DIR . 'media/avatar/140x140/' . $_POST['id'] . '.jpg', $sizeLarge[0], (isset ($sizeLarge[1])) ? $sizeLarge[1] : false, true);
			redimage($original, ROOT_DIR . 'media/avatar/80x80/' . $_POST['id'] . '.jpg', $sizeMedium[0], (isset ($sizeMedium[1])) ? $sizeMedium[1] : false, true);
			redimage($original, ROOT_DIR . 'media/avatar/25x25/' . $_POST['id'] . '.jpg', $sizeSmall[0], (isset ($sizeSmall[1])) ? $sizeSmall[1] : false, true);
		}
	}

	header('Location: ' . ROOT_PATH . $_POST['login']);

