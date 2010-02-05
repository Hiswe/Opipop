<?php

class Block_Top extends Block
{
	public function configure()
	{
		// If a user is connected get its infos
		if (Tool::isOk($_SESSION['user']))
		{
			$this->tpl->assignVar(array
			(
				'user_login' => $_SESSION['user']['login'],
				'user_id'    => $_SESSION['user']['id'],
			));
			$this->tpl->assignSection('logged');
		}
		else
		{
			$this->tpl->assignSection('notLogged');
		}

		// If a feedback should be displayed
		if (Tool::isOk($_SESSION['feedback']))
		{
			$this->tpl->assignSection('feedback');
			$this->tpl->assignVar('feedback', $_SESSION['feedback']);
			unset($_SESSION['feedback']);
		}

		// List categories
		$rs_category = DB::select('SELECT `id`, `label`, `guid` FROM `category` WHERE `status`="1" ORDER BY `position` ASC');
		foreach ($rs_category['data'] as $category)
		{
			$this->tpl->assignLoopVar('category', array
			(
				'id' => $category['id'],
				'label' => $category['label'],
				'guid' => $category['guid'],
			));
		}
	}
}

