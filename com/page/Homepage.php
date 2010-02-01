<?php

include 'com/block/Top.php';

class Page_Homepage extends Page
{
	public function configureData()
	{
		$top = new Block_Top($this->tpl);
		$top->configure();
	}

	public function configureView()
	{
		$this->tpl->assignTemplate ('com/view/header.tpl');
		$this->tpl->assignTemplate ('com/view/top.tpl');
		$this->tpl->assignTemplate ('com/view/homepage.tpl');
		$this->tpl->assignTemplate ('com/view/footer.tpl');
	}
}

