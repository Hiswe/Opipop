<?php

class Page_Register extends Page
{
	public function configureView()
	{
		$this->tpl->assignTemplate('lib/view/header.tpl');
		$this->tpl->assignTemplate('lib/view/top.tpl');
		$this->tpl->assignTemplate('lib/view/register.tpl');
		$this->tpl->assignTemplate('lib/view/footer.tpl');
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

