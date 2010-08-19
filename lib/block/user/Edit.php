<?php

class Block_User_Edit extends Block
{
    protected $_TEMPLATE = 'lib/view/user/edit.tpl';

    private $user = null;

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function configure()
    {
        // If no user is logged or this page's user is not logged
        if (!($user = Model_User::getLoggedUser()) || strtolower($user->getId()) == strtolower($this->user->getId()))
        {
            // TODO : 500
        }

        $this->tpl->assignSection('private');
        $this->tpl->assignVar(array
        (
            'profile_id'     => $user->getId(),
            'profile_login'  => $user->getLogin(),
            'profile_male'   => $user->getGender(),
            'profile_zip'    => $user->getZip(),
            'profile_avatar' => $user->getAvatarUri('large'),

            'profile_edit_zip_' . $user->getZip()     => ' selected="selected"',
            'profile_edit_gender_' . $user->getGender() => ' selected="selected"',
        ));
    }
}

