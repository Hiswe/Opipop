<?php

class Page_User_Edit extends Page
{
	public function configureView()
	{
		$this->tpl->assignTemplate('lib/view/header.tpl');
		$this->tpl->assignTemplate('lib/view/top.tpl');
		$this->tpl->assignTemplate('lib/view/user_header.tpl');
		$this->tpl->assignTemplate('lib/view/user_menu.tpl');
		$this->tpl->assignTemplate('lib/view/user_edit.tpl');
		$this->tpl->assignTemplate('lib/view/footer.tpl');
	}

	public function configureData()
	{
        // Configure top block
		$top = new Block_Top($this->tpl);
		$top->configure();

        // If no user is logged or this page's user is not logged
        if (!Tool::isOk($_SESSION['user']) || strtolower($_SESSION['user']['login']) == strtolower($this->getParameter('login')))
        {
            // TODO : 500
        }

        $user = new Model_User($_SESSION['user']['id']);

        $this->tpl->assignSection('private');
        $this->tpl->assignVar(array
        (
            'profile_id'     => $user->getId(),
            'profile_login'  => $user->getLogin(),
            'profile_male'   => $user->getMale(),
            'profile_zip'    => $user->getZip(),
            'profile_avatar' => $user->getAvatarUri('large'),

            'profile_edit_zip_' . $user->getZip()     => ' selected="selected"',
            'profile_edit_gender_' . $user->getMale() => ' selected="selected"',
        ));
    }
}

