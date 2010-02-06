<?php

class Page_User_List extends Page
{
	public function configureView()
	{
		$this->tpl->assignTemplate('lib/view/header.tpl');
		$this->tpl->assignTemplate('lib/view/top.tpl');
		$this->tpl->assignTemplate('lib/view/user_list.tpl');
		$this->tpl->assignTemplate('lib/view/footer.tpl');
	}

	public function configureData()
	{
        // Configure top block
		$top = new Block_Top($this->tpl);
		$top->configure();

        // If a user is logged
        if (Tool::isOk($_SESSION['user']))
        {
			$reader = new Model_User($_SESSION['user']['id']);
		}

		// If we made a search
		$query = $this->getParameter('query');
		if ($query != false && !empty($query))
		{
			$tpl->assignVar(array
			(
				'search_query' => utf8_encode(htmlspecialchars(rawurldecode(stripslashes($query))))
			));
			$users = Model_User::search($this->getPage(), $query);
		}
		else
		{
			$users = Model_User::search($this->getPage());
		}

		// List all users
		foreach ($users as $user)
		{
			$this->tpl->assignLoopVar('user', array
			(
				'id'     => $user->getId(),
				'login'  => $user->getLogin(),
				'avatar' => $user->getAvatarUri('small'),
			));

			if (Tool::isOk($_SESSION['user']) && $user->getId() != $_SESSION['user']['id'])
			{
				switch ($reader->getFriendStatus($user))
				{
					case Model_User::FRIEND_STATUS_NONE :
						$friendMessage = 'Add to friends';
						$friendAction  = 'add';
						break;
					case Model_User::FRIEND_STATUS_PENDING :
						$friendMessage = 'Cancel friend request';
						$friendAction  = 'cancel';
						break;
					case Model_User::FRIEND_STATUS_VALIDED :
						$friendMessage = 'Remove from friends';
						$friendAction  = 'remove';
						break;
				}

				$this->tpl->assignLoopVar('user.friendRequest', array
				(
					'message' => $friendMessage,
					'action'  => $friendAction,
				));
			}
		}
    }
}



