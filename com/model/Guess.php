<?php

class Guess
{
    protected $id;
    protected $data;

	public function Guess($id, $data = array())
	{
		if (is_numeric($id))
		{
            $this->id = $id;
			$this->data = $data;
		}
		else
		{
            // TODO : Error 500
		}
	}

    public function getId()
    {
        return $this->id;
    }

    public function getAnswer()
    {
        return new Answer($this->id);
    }

    public function getUser()
    {
		if (!$this->data['user'])
		{
            // TODO : Error 500
		}
        return $this->data['user'];
    }
}

