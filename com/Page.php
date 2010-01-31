<?php

class Page
{
	protected $tpl;
	protected $params;

	public function Page($tpl)
	{
		$this->tpl = $tpl;
		$this->gatherParameterFromRequest();
	}

	public function getParameter($name)
	{
		if (in_array($name, $this->params))
		{
			return $this->params[$name];
		}
		return false;
	}

	protected function gatherParameterFromRequest()
	{
		$this->params = array();
		foreach ($_GET as $key => $value)
		{
			$this->params[$key] = $value;
		}
	}

	public function configureData(){}
	public function configureView(){}
}

