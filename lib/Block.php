<?php

class Block
{
	protected $tpl;
	protected $isAjax;

	public function BlocK($tpl)
	{
		$this->tpl = $tpl;
		$this->isAjax = false;
	}

	public function setIsAjax($value = true)
	{
		$this->isAjax = $value;
	}

	public function isAjax()
	{
		return $this->isAjax;
	}

	public function configure(){}
}

