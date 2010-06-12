<?php

class Block_Top extends Block
{
    public function configure()
    {
        if ($user = Model_User::getLoggedUser())
        {
            $this->tpl->assignVar(array
            (
                'user_login' => $user->getLogin(),
                'user_id'    => $user->getId(),
            ));
            $this->tpl->assignSection('logged');
        }
        else
        {
            $this->tpl->assignVar(array
            (
                'user_login' => '',
                'user_id'    => 0,
            ));
            $this->tpl->assignSection('notLogged');
        }

        // If a feedback should be displayed
        if (Tool::isOk($_SESSION['feedback']))
        {
            $this->tpl->assignSection('feedback');
            $this->tpl->assignVar('feedback', $_SESSION['feedback']);
            unset($_SESSION['feedback']);
        }

        // If a feedback should be displayed
        if (Tool::isOk($_SESSION['warning']))
        {
            $this->tpl->assignSection('warning');
            $this->tpl->assignVar('warning', $_SESSION['warning']);
            unset($_SESSION['warning']);
        }

        // Did you know ?
        $question   = Model_Question::getRandomQuestion();
        $answers    = $question->getAnswers();
        $didyouknow = $question->getDidyouknow();
        foreach ($answers as $key => $answer)
        {
            $didyouknow = str_replace('{PERCENT_' . ($key + 1) . '}', number_format($answer->getPercent($question->getId()), 1, ',', ' '), $didyouknow);
        }
        $this->tpl->assignVar(array
        (
            'didyouknow_label' => $didyouknow,
            'didyouknow_id'    => $question->getId(),
            'didyouknow_guid'  => Tool::makeGuid($question->getLabel()),
        ));
    }
}

