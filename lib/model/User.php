<?php

class Model_User
{
    const FRIEND_STATUS_NONE    = 0;
    const FRIEND_STATUS_PENDING = 1;
    const FRIEND_STATUS_VALIDED = 2;

    protected $data;
    protected $feelings;
    protected $friends;
    protected $pendingFriends;
    protected $answerGlobalStats;
    protected $answerFriendStats;
    protected $guessGlobalStats;
    protected $guessFriendsStats;

    public function Model_User($id, $data = array())
    {
        if (preg_match('/^(\d+)$/', $id) == 0)
        {
            $this->fetchData($id);
        }
        else
        {
            $this->data = $data;
            $this->data['id'] = $id;
        }
    }

    private function fetchData($login = false)
    {
        if (!$this->data['id'] && $login)
        {
            $where = '`login`="' . $login . '"';
        }
        else
        {
            $where = '`id`="' . $this->data['id'] . '"';
        }
        $rs = DB::select('
            SELECT `id`, `login`, `valided`, `male`, `email`, `zip`
            FROM `user`
            WHERE ' . $where . '
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
            SELECT u.login, u.id, u.male, u.zip, u.email, u.valided
            FROM `friend` AS `f`
            JOIN `user` AS `u` ON u.id=f.user_id_1 OR u.id=f.user_id_2
            WHERE f.valided="1" AND (f.user_id_1="' . $this->data['id'] . '" OR f.user_id_2="' . $this->data['id'] . '")
            AND u.id!="' . $this->data['id'] . '"
        ');
        $this->friends = array();
        foreach ($rs['data'] as $friend)
        {
            $this->friends[] = new Model_User($friend['id'], $friend);
        }
    }

    private function fetchPendingFriends()
    {
        $rs = DB::select('
            SELECT u.login, u.id, u.male, u.zip, u.email, u.valided
            FROM `friend` AS `f`
            JOIN `user` AS `u` ON u.id=f.user_id_1
            WHERE f.valided="0" AND f.user_id_2="' . $this->data['id'] . '"
        ');
        $this->pendingFriends = array();
        foreach ($rs['data'] as $friend)
        {
            $this->pendingFriends[] = new Model_User($friend['id'], $friend);
        }
    }

    public function getAnswer($question)
    {
        $rs = DB::select
        ('
            SELECT `answer_id`
            FROM `user_result`
            WHERE `question_id`=' . $question->getId() . ' AND `user_id`="' . $this->data['id'] . '"
        ');
        if ($rs['total'] != 0)
        {
            return new Model_Answer($rs['data'][0]['answer_id']);
        }
        return false;
    }

    public function getGuess($question)
    {
        $rs = DB::select
        ('
            SELECT `answer_id`
            FROM `user_guess`
            WHERE `question_id`=' . $question->getId() . ' AND `user_id`="' . $this->data['id'] . '"
        ');
        if ($rs['total'] != 0)
        {
            return new Model_Guess($rs['data'][0]['answer_id'], array
            (
                'user' => $this
            ));
        }
        return false;
    }

    public function getGuessesAboutFriends($question)
    {
        $rs = DB::select
        ('
            SELECT g.answer_id, u.login, u.id, u.male, u.zip, u.email, u.valided
            FROM `user_guess_friend` AS `g`
            JOIN `friend` AS `f`
                ON (f.user_id_1=g.user_id AND f.user_id_2=g.friend_id)
                OR (f.user_id_1=g.friend_id AND f.user_id_2=g.user_id)
            JOIN `user` AS `u`
                ON u.id=g.friend_id
            WHERE `question_id`=' . $question->getId() . ' AND `user_id`="' . $this->data['id'] . '"
        ');
        $guesses = array();
        foreach ($rs['data'] as $guess)
        {
            $guesses[] = new Model_Guess($guess['answer_id'], array
            (
                'user' => new Model_User($guess['id'], array
                (
                    'login'   => $guess['login'],
                    'valided' => $guess['valided'],
                    'email'   => $guess['email'],
                    'zip'     => $guess['zip'],
                    'male'    => $guess['male'],
                ))
            ));
        }
        return $guesses;
    }

    public function getAnswerGlobalStats()
    {
        if (!isset($this->answerGlobalStats))
        {
            $rs = DB::select('
                SELECT
                    COUNT(rg.answer_id) AS `votes`,
                    SUM(IF(rg.answer_id=ru.answer_id, 1, 0)) AS `popularVotes`,
                    SUM(IF(rg.answer_id!=ru.answer_id, 1, 0)) AS `unpopularVotes`
                FROM `user_result` AS `rg`
                JOIN `user_result` AS `ru` ON ru.user_id="' . $this->data['id'] . '" AND rg.question_id=ru.question_id
                JOIN `question` AS `q` ON q.id=rg.question_id
                WHERE q.date < ' . (time() - QUESTION_DURATION) . '
            ');
            if ($rs['total'] == 0)
            {
                $this->answerGlobalStats = array
                (
                    'votes'          => 0,
                    'popularVotes'   => 0,
                    'unpopularVotes' => 0
                );
            }
            else
            {
                $this->answerGlobalStats = $rs['data'][0];
            }
        }
        return $this->answerGlobalStats;
    }

    public function getAnswerFriendStats()
    {
        if (!isset($this->answerFriendStats))
        {
            $rs = DB::select('
                SELECT
                    COUNT(rg.answer_id) AS `votes`,
                    SUM(IF(rg.answer_id=ru.answer_id, 1, 0)) AS `popularVotes`,
                    SUM(IF(rg.answer_id!=ru.answer_id, 1, 0)) AS `unpopularVotes`
                FROM `user_result` AS `rg`
                JOIN `user_result` AS `ru` ON ru.user_id="' . $this->data['id'] . '" AND rg.question_id=ru.question_id
                JOIN `question` AS `q` ON q.id=rg.question_id
                JOIN `friend` AS f
                    ON (f.user_id_1="' . $this->data['id'] . '" AND f.user_id_2=rg.user_id AND f.valided=1)
                    OR (f.user_id_1=rg.user_id AND f.user_id_2="' . $this->data['id'] . '" AND f.valided=1)
                WHERE q.date < ' . (time() - QUESTION_DURATION) . '
            ');
            if ($rs['total'] == 0)
            {
                $this->answerFriendStats = array
                (
                    'votes'          => 0,
                    'popularVotes'   => 0,
                    'unpopularVotes' => 0
                );
            }
            else
            {
                $this->answerFriendStats = $rs['data'][0];
            }
        }
        return $this->answerFriendStats;
    }

    public function getGuessGlobalStats()
    {
        if (!isset($this->guessGlobalStats))
        {
            $rs = DB::select('
                SELECT
                    COUNT(rg.answer_id) AS `guesses`,
                    SUM(IF(rg.answer_id=gu.answer_id, 1, 0)) AS `popularGuesses`,
                    SUM(IF(rg.answer_id!=gu.answer_id, 1, 0)) AS `unpopularGuesses`
                FROM `user_result` AS `rg`
                JOIN `user_guess` AS `gu` ON gu.user_id="' . $this->data['id'] . '" AND rg.question_id=gu.question_id
                JOIN `question` AS `q` ON q.id=rg.question_id
                WHERE q.date < ' . (time() - QUESTION_DURATION - 3600) . '
            ');
            if ($rs['total'] == 0)
            {
                $this->guessGlobalStats = array
                (
                    'guesses'          => 0,
                    'popularGuesses'   => 0,
                    'unpopularGuesses' => 0
                );
            }
            else
            {
                $this->guessGlobalStats = $rs['data'][0];
            }
        }
        return $this->guessGlobalStats;
    }

    public function getGuessFriendsStats()
    {
        if (!isset($this->guessFriendsStats))
        {
            $rs = DB::select('
                SELECT
                    u.login,
                    u.id,
                    u.male,
                    u.zip,
                    u.email,
                    u.valided,
                    COUNT(g.question_id) AS `guesses`,
                    SUM(IF(g.answer_id=r.answer_id, 1, 0)) AS `popularGuesses`,
                    SUM(IF(g.answer_id!=r.answer_id, 1, 0)) AS `unpopularGuesses`
                FROM `user_guess_friend` AS `g`
                JOIN `user` AS `u` ON g.friend_id=u.id
                JOIN `user_result` AS `r` ON g.question_id=r.question_id
                JOIN `question` AS `q` ON q.id=g.question_id
                JOIN `friend` AS f
                    ON (f.user_id_1="' . $this->data['id'] . '" AND f.user_id_2=g.friend_id AND f.valided=1)
                    OR (f.user_id_1=g.friend_id AND f.user_id_2="' . $this->data['id'] . '" AND f.valided=1)
                WHERE g.user_id="' . $this->data['id'] . '"
                AND q.date < ' . (time() - QUESTION_DURATION - 3600) . '
                GROUP BY g.friend_id
            ');
            $this->guessFriendsStats = array();
            foreach ($rs['data'] as $friend)
            {
                $this->guessFriendsStats[] = array
                (
                    'guesses'          => $friend['guesses'],
                    'popularGuesses'   => $friend['popularGuesses'],
                    'unpopularGuesses' => $friend['unpopularGuesses'],
                    'user'             => new Model_User($friend['id'], array
                    (
                        'login' => $friend['login'],
                        'zip'   => $friend['zip'],
                        'male'  => $friend['male'],
                        'email' => $friend['email'],
                        'login' => $friend['login'],
                    )),
                );
            }
        }
        return $this->guessFriendsStats;
    }

    public function getFriendStatus($user)
    {
        $rs = DB::select('
            SELECT `valided`
            FROM `friend`
            WHERE (`user_id_1`="' . $this->data['id'] . '" AND `user_id_2`="' . $user->getId() . '")
            OR (`user_id_1`="' . $user->getId() . '" AND `user_id_2`="' . $this->data['id'] . '")
        ');
        if ($rs['total'] == 0)
        {
            return Model_User::FRIEND_STATUS_NONE;
        }
        else if ($rs['data'][0]['valided'] == 1)
        {
            return Model_User::FRIEND_STATUS_VALIDED;
        }
        else
        {
            return Model_User::FRIEND_STATUS_PENDING;
        }
    }

    public function getTotalVotes()
    {
        if (!isset($this->data['total_vote']))
        {
            $rs = DB::select('
                SELECT COUNT(*) AS `total`
                FROM `user_result`
                WHERE `user_id`="' . $this->data['id'] . '"
            ');
            $this->data['total_vote'] = $rs['data'][0]['total'];
        }
        return $this->data['total_vote'];
    }

    public function getFriends()
    {
        if (!isset($this->friends))
        {
            $this->fetchFriends();
        }
        return $this->friends;
    }

    public function getPendingFriends()
    {
        if (!isset($this->pendingFriends))
        {
            $this->fetchPendingFriends();
        }
        return $this->pendingFriends;
    }

    public function getFeelings()
    {
        if (!isset($this->feelings))
        {
            $rs = DB::select('
                SELECT f.id, COUNT(f.id) AS total
                FROM `user_result` AS `r`
                JOIN `question_answer_feeling` AS `j` ON j.question_id=r.question_id AND j.answer_id=r.answer_id
                JOIN `feeling` AS `f` ON f.id=j.feeling_id
                WHERE r.user_id="' . $this->data['id'] . '" AND f.id!="1"
                GROUP BY f.id
            ');
            $this->feelings = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0);
            foreach ($rs['data'] as $item)
            {
                $this->feelings[$item['id']] = $item['total'];
            }
        }
        return $this->feelings;
    }

    public function vote($questionId, $answerId)
    {
        DB::insert('INSERT INTO `user_result` (`question_id`, `answer_id`, `user_id`, `date`) VALUES
        (
            "' . $questionId . '",
            "' . $answerId . '",
            "' . $this->data['id'] . '",
            "' . time() . '"
        )');
    }

    public function guess($questionId, $answerId)
    {
        DB::insert('INSERT INTO `user_guess` (`question_id`, `answer_id`, `user_id`, `date`) VALUES
        (
            "' . $questionId . '",
            "' . $answerId . '",
            "' . $this->data['id'] . '",
            "' . time() . '"
        )');
    }

    public function removeVote($questionId)
    {
        DB::delete('DELETE FROM `user_result` WHERE `question_id`=' . $questionId . ' AND `user_id`=' . $this->data['id']);
    }

    public function removeGuess($questionId)
    {
        DB::delete('DELETE FROM `user_guess` WHERE `question_id`=' . $questionId . ' AND `user_id`=' . $this->data['id']);
    }

    public function updateVote($questionId, $answerId)
    {
        DB::update('UPDATE `user_result`
            SET `answer_id` = ' . $answerId . '
            WHERE `question_id`=' . $questionId . ' AND `user_id`=' . $this->data['id']);
    }

    public function updateGuess($questionId, $answerId)
    {
        DB::update('UPDATE `user_guess`
            SET `answer_id` = ' . $answerId . '
            WHERE `question_id`=' . $questionId . ' AND `user_id`=' . $this->data['id']);
    }

	public function guessAboutFriend($questionId, $friendId, $answerId)
	{
		DB::insert('INSERT INTO `user_guess_friend` (`question_id`, `friend_id`, `answer_id`, `user_id`, `date`) VALUES
		(
			"' . $questionId . '",
			"' . $friendId . '",
			"' . $answerId . '",
			"' . $this->data['id'] . '",
			"' . time() . '"
		)');
	}

	public function removeGuessAboutFriend($questionId, $friendId)
	{
        DB::delete('DELETE FROM `user_guess_friend` WHERE `question_id`=' . $questionId . ' AND `friend_id`=' . $friendId . ' AND `user_id`=' . $this->data['id']);
	}

	public function updateGuessAboutFriend($questionId, $friendId, $answerId)
	{
        DB::update('UPDATE `user_guess_friend`
            SET `answer_id` = ' . $answerId . '
            WHERE `question_id`=' . $questionId . ' AND `friend_id`=' . $friendId . ' AND `user_id`=' . $this->data['id']);
	}

    public function getId()
    {
        return $this->data['id'];
    }

    public function getLogin()
    {
        if (!isset($this->data['login']))
        {
            $this->fetchData();
        }
        return $this->data['login'];
    }

    public function getActive()
    {
        if (!isset($this->data['active']))
        {
            $this->fetchData();
        }
        return $this->data['active'];
    }

    public function getEmail()
    {
        if (!isset($this->data['email']))
        {
            $this->fetchData();
        }
        return $this->data['email'];
    }

    public function getMale()
    {
        if (!isset($this->data['male']))
        {
            $this->fetchData();
        }
        return $this->data['male'];
    }

    public function getZip()
    {
        if (!isset($this->data['zip']))
        {
            $this->fetchData();
        }
        return $this->data['zip'];
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

            case 'large':
                $size = AVATAR_LARGE_SIZE;
                break;
        }
        if (file_exists(ROOT_DIR . 'media/avatar/' . $size . '/' . $this->data['id'] . '.jpg'))
        {
            return 'media/avatar/' . $size . '/' . $this->data['id'] . '.jpg';
        }
        return 'media/avatar/' . $size . '/0.jpg';
    }

    public static function search($page = false, $query = false)
    {
        $from = ((!$page) ? 0 : $page - 1) * QUESTION_PER_PAGE;
        $max = ($page === false) ? 0 : QUESTION_PER_PAGE;

        $rs = DB::select('
            SELECT u.id, u.login, u.valided, u.male, u.email, u.zip
            FROM `user` AS `u`
            JOIN `user_result` AS `r` ON r.user_id=u.id
            WHERE valided="1" ' . (($query) ? ' AND u.login LIKE(\'' . Tool::getLikeList($query) . '\')' : '') . '
            GROUP BY u.id
            ORDER BY u.register_date DESC
        ', $from, $max);

        $users = array();
        foreach ($rs['data'] as $user)
        {
            $users[] = new Model_User($user['id'], $user);
        }
        return $users;
    }
}

