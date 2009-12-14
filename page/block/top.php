<?php

if (isOk($_SESSION['user']))
{
    foreach($_SESSION['user'] as $id => $data)
    {
        $tpl->assignLoopVar('userLogged', array
        (
            'login' => $data['login'],
            'id'    => $data['id'],
        ));
    }
}

