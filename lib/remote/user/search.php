<?php

class Remote_User_Search extends Remote
{
    public $AJAXONLY = true;

    public function configureData()
    {
        if (!($reader = Model_User::getLoggedUser()))
        {
            $_SESSION['warning'] = 'You need to be logged to add users to your friends';
            echo 'register';
            exit();
        }

        header('Content-Type: application/json; charset=utf-8');
        header("Cache-Control: no-cache");

        $result = array();

        if (isset($_POST['query']) && !empty($_POST['query']))
        {
            $users = Model_User::search($_POST['query']);

            foreach ($users as $user)
            {
                if ($user->getId() != $reader->getId())
                {
                    $result[] = array
                    (
                        'id'     => $user->getId(),
                        'login'  => $user->getLogin(),
                        'avatar' => $user->getAvatarURL('small'),
                    );
                }
            }
        }

        echo json_encode($result);
    }
}

