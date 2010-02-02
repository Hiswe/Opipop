<?php

class User
{
    protected $id;
    protected $data;
    protected $friends;

	public function User($id, $data = array())
	{
		if (is_string($id))
		{
            $this->id = $id;
			$this->data = $data;
		}
		else
		{
            // TODO : Error 500
		}
	}

	private function fetchData()
	{
		$rs = DB::select('
			SELECT `id`, `login`, `valided`
			FROM `user`
			WHERE `id`="' . $this->id . '"
		');
		if ($rs['total'] == 0)
		{
            // TODO : Error 500
		}
		$this->data = $rs['data'][0];
	}

	private function fetchFriends()
	{
		$rs = DB::select('
			SELECT u.login, u.id
			FROM `friend` AS `f`
			JOIN `user` AS `u` ON u.id=f.user_id_1 OR u.id=f.user_id_2
			WHERE f.valided="1" AND (f.user_id_1="' . $this->id . '" OR f.user_id_2="' . $this->id . '")
			AND u.id!="' . $this->id . '"
		');
		foreach ($rs['data'] as $friend)
		{
			$this->friends[] = new User($friend['id'], array
			(
				'login' => $friend['login'],
			));
		}
	}

    public function getAnswer($questionId)
    {
        $rs = DB::select
		('
			SELECT `answer_id`
			FROM `user_result`
			WHERE `question_id`=' . $questionId . ' AND `user_id`="' . $this->id . '"
		');
		if ($rs['total'] != 0)
		{
			return new Answer($rs['data'][0]['answer_id']);
		}
		return false;
    }

    public function getGuess($questionId)
    {
        $rs = DB::select
		('
			SELECT `answer_id`
			FROM `user_guess`
			WHERE `question_id`=' . $questionId . ' AND `user_id`="' . $this->id . '"
		');
		if ($rs['total'] != 0)
		{
			return new Guess($rs['data'][0]['answer_id'], array
			(
				'user' => $this
			));
		}
		return false;
    }

	public function getGuessesForFriends($questionId)
	{
        $rs = DB::select
		('
			SELECT g.answer_id, u.id, u.login, u.valided
			FROM `user_guess_friend` AS `g`
			JOIN `friend` AS `f`
				ON (f.user_id_1=g.user_id AND f.user_id_2=g.friend_id)
				OR (f.user_id_1=g.friend_id AND f.user_id_2=g.user_id)
			JOIN `user` AS `u`
				ON u.id=g.friend_id
			WHERE `question_id`=' . $questionId . ' AND `user_id`="' . $this->id . '"
		');
		if ($rs['total'] != 0)
		{
			$guesses = array();
			foreach ($rs['data'] as $guess)
			{
				$guesses[] = new Guess($guess['answer_id'], array
				(
					'user' => new User($guess['id'], array
					(
						'login'   => $guess['login'],
						'valided' => $guess['valided'],
					))
				));
			}
			return $guesses;
		}
		return false;
	}

	public function getFriends()
	{
		if (!$this->friends)
		{
			$this->fetchFriends();
		}
		return $this->friends;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getLogin()
	{
		if (!$this->data)
		{
			$this->fetchData();
		}
		return $this->data['login'];
	}

	public function getActive()
	{
		if (!$this->data)
		{
			$this->fetchData();
		}
		return $this->data['active'];
	}

	public function getAvatarUri($type)
	{
		switch ($type)
		{
			case 'small':
				$size = AVATAR_SMALL_SIZE;
				break;

			case 'medium':
				$size = AVATAR_MEDIUM_SIZE;
				break;

			case 'big':
				$size = AVATAR_LARGE_SIZE;
				break;
		}
		if (file_exists(ROOT_DIR . 'media/avatar/' . AVATAR_SMALL_SIZE . '/' . $this->id . '.jpg'))
		{
			return 'media/avatar/' . AVATAR_SMALL_SIZE . '/' . $this->id . '.jpg';
		}
		return 'media/avatar/' . AVATAR_SMALL_SIZE . '/0.jpg';
	}
}

