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
		$this->tpl->assignTemplate ('template/block/header.tpl');
		$this->tpl->assignTemplate ('template/block/top.tpl');
		$this->tpl->assignTemplate ('template/homepage.tpl');
		$this->tpl->assignTemplate ('template/block/footer.tpl');
	}
}

