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

	private function gatherParameterFromRequest()
	{
		$this->params = array();
		foreach ($_GET as $key => $value)
		{
			$this->params[$key] = $value;
		}
	}

	protected function getParameter($name)
	{
		if (array_key_exists($name, $this->params))
		{
			return $this->params[$name];
		}
		return false;
	}

    protected function getPage()
    {
        if ($this->getParameter('p') !== false)
        {
            return $this->getParameter('p');
        }
        return 0;
    }

	public function configureData(){}
	public function configureView(){}
}

