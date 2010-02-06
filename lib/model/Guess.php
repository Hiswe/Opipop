<?php

class Model_Guess
{
    protected $data;

	public function Model_Guess($id, $data = array())
	{
		if (preg_match('/^(\d+)$/', $id) != 0)
		{
			$this->data = $data;
            $this->data['id'] = $id;
		}
		else
		{
            // TODO : Error 500
		}
	}

    public function getId()
    {
        return $this->data['id'];
    }

    public function getAnswer()
    {
        return new Model_Answer($this->data['id']);
    }

    public function getUser()
    {
		if (!isset($this->data['user']))
		{
            // TODO : Error 500
		}
        return $this->data['user'];
    }
}

