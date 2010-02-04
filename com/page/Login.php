<?php

class Page_Login extends Page
{
	public function configureView()
	{
		$this->tpl->assignTemplate('com/view/header.tpl');
		$this->tpl->assignTemplate('com/view/top.tpl');
		$this->tpl->assignTemplate('com/view/login.tpl');
		$this->tpl->assignTemplate('com/view/footer.tpl');
	}

	public function configureData()
	{
		$top = new Block_Top($this->tpl);
		$top->configure();

		// If some user are connected
		if (Tool::isOk($_SESSION['user']))
		{
			$this->tpl->assignSection('noLogin');
		}
		else
		{
			$this->tpl->assignSection('login');
		}
	}
}

