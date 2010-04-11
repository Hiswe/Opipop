<?php

    // Logout user
    if (isset($_SESSION['user']))
    {
        unset($_SESSION['user']);
    }

    // Go back to home or to where I was
    if (substr($_SERVER['HTTP_REFERER'], 0, strlen(Conf:get('ROOT_PATH'))) == Conf:get('ROOT_PATH'))
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else
    {
        header('Location: ' . Conf:get('ROOT_PATH'));
    }

