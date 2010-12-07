<?php

class Remote_User_Edit_Submit extends Remote
{
    public $AJAXONLY = true;

    public function configureData()
    {
        if (!Tool::isOk($_POST['id']) || !($user = Model_User::getLoggedUser()) || $user->getId() != $_POST['id'] || !Tool::isOk($_POST['zip']) || !isset($_POST['gender']) || !Tool::isOk($_POST['login']))
        {
            header('Location: ' . Conf::get('ROOT_PATH'));
            exit();
        }

        DB::update('UPDATE `user` SET
            `zip`="' . $_POST['zip'] . '",
            `male`="' . $_POST['gender'] . '"
            WHERE `id`="' . $_POST['id'] . '"');

        if (isset($_FILES) && isset($_FILES['avatar']) && $_FILES['avatar']['error'] != 4)
        {
            $size = filesize($_FILES['avatar']['tmp_name']);
            $stat = stat($_FILES['avatar']['tmp_name']);

            if ($size[0] <= 1680 && $size[1] <= 1680 && $stat['size'] <= 450 * 1024)
            {
                $extention = strtolower(preg_replace('#.+\.([a-zA-Z]+)$#isU', '$1', $_FILES['avatar']['name']));
                $original  = Conf::get('MEDIA_DIR'). 'avatar/original/' . $_POST['id'] . '.' . $extention;

                move_uploaded_file($_FILES['avatar']['tmp_name'], $original);

                $sizeSmall  = explode('x', Conf::get('AVATAR_SMALL_SIZE'));
                $sizeMedium = explode('x', Conf::get('AVATAR_MEDIUM_SIZE'));
                $sizeLarge  = explode('x', Conf::get('AVATAR_LARGE_SIZE'));

                Tool::redimage($original, Conf::get('MEDIA_DIR') . 'avatar/' . Conf::get('AVATAR_LARGE_SIZE') . '/' . $_POST['id'] . '.jpg', $sizeLarge[0], (isset ($sizeLarge[1])) ? $sizeLarge[1] : false, true);
                Tool::redimage($original, Conf::get('MEDIA_DIR') . 'avatar/' . Conf::get('AVATAR_MEDIUM_SIZE') . '/' . $_POST['id'] . '.jpg', $sizeMedium[0], (isset ($sizeMedium[1])) ? $sizeMedium[1] : false, true);
                Tool::redimage($original, Conf::get('MEDIA_DIR') . 'avatar/' . Conf::get('AVATAR_SMALL_SIZE'). '/' . $_POST['id'] . '.jpg', $sizeSmall[0], (isset ($sizeSmall[1])) ? $sizeSmall[1] : false, true);
            }
        }

        $_SESSION['feedback'] = 'Your informations has been updated';

        header('Location: ' . Conf::get('ROOT_PATH'). $_POST['login']);
    }
}

