<?php

if (isset($_SESSION['user']))
{
    unset($_SESSION['user']);
}

if (substr($_SERVER['HTTP_REFERER'], 0, strlen(ROOT_PATH)) == ROOT_PATH)
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else
{
    header('Location: ' . ROOT_PATH);
}

