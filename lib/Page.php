<?php

class Page
{
    protected $tpl;
    protected $params;

    public function Page($tpl)
    {
        $this->tpl = $tpl;
        $this->gatherParameterFromRequest();

		if (Conf::get('PROD'))
		{
			$this->tpl->assignSection('prod_environement');
		}
		else
		{
			foreach (scandir(Conf::get('ROOT_DIR') . 'js/lib') as $file)
			{
				if (preg_match('/(\.js)$/i', $file))
				{
					$this->tpl->assignLoopVar('dev_script_list', array
					(
						'file' => 'js/lib/' . $file,
					));
				}
			}
			foreach (scandir(Conf::get('ROOT_DIR') . 'js') as $file)
			{
				if (preg_match('/(\.js)$/i', $file))
				{
					$this->tpl->assignLoopVar('dev_script_list', array
					(
						'file' => 'js/' . $file,
					));
				}
			}
		}
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

