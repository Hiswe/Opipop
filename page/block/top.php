<?php

// If some user are connected
if (isOk($_SESSION['user']))
{
    // List them
    foreach($_SESSION['user'] as $id => $data)
    {
        $tpl->assignLoopVar('userLogged', array
        (
            'login' => $data['login'],
            'id'    => $id,
        ));
    }
}

