<?php

class Block
{
    protected $_TEMPLATE = '';

    protected $tpl;
    protected $isAjax;

    public function BlocK($tpl = null)
    {
        if (isset($tpl))
        {
            $this->tpl = $tpl;
        }
        else
        {
            $this->tpl = new Template();
        }
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

    public function render()
    {
        $this->tpl->assignTemplate($this->_TEMPLATE);
        return $this->tpl->display(true);
    }

    public function configure(){}
}

