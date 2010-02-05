<?php

class Page_Homepage extends Page
{
	public function configureView()
	{
		$this->tpl->assignTemplate('lib/view/header.tpl');
		$this->tpl->assignTemplate('lib/view/top.tpl');
		$this->tpl->assignTemplate('lib/view/homepage.tpl');
		$this->tpl->assignTemplate('lib/view/footer.tpl');
	}

	public function configureData()
	{
        // Configure top block
		$top = new Block_Top($this->tpl);
		$top->configure();
	}
}

