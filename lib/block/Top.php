<?php

class Block_Top extends Block
{
    protected $template = 'lib/view/top.tpl';

    public function configure()
    {
        if ($user = Model_User::getLoggedUser())
        {
            Globals::$tpl->assignVar(array
            (
                'user_login'     => $user->getLogin(),
                'user_id'        => $user->getId(),
                'user_avatarURL' => $user->getAvatarURL('medium'),
            ));
            Globals::$tpl->assignSection('logged');
        }
        else
        {
            Globals::$tpl->assignVar(array
            (
                'user_login' => '',
                'user_id'    => 0,
            ));
            Globals::$tpl->assignSection('notLogged');
        }

        // If a feedback should be displayed
        if (Tool::isOk($_SESSION['feedback']))
        {
            Globals::$tpl->assignSection('feedback');
            Globals::$tpl->assignVar('feedback', $_SESSION['feedback']);
            unset($_SESSION['feedback']);
        }

        // If a warning should be displayed
        if (Tool::isOk($_SESSION['warning']))
        {
            Globals::$tpl->assignSection('warning');
            Globals::$tpl->assignVar('warning', $_SESSION['warning']);
            unset($_SESSION['warning']);
        }

        // Did you know ?
        //$question   = Model_Question::getRandomQuestion();
        //$answers    = $question->getAnswers();
        //$didyouknow = $question->getDidyouknow();
        //foreach ($answers as $key => $answer)
        //{
            //$didyouknow = str_replace('{PERCENT_' . ($key + 1) . '}', number_format($answer->getPercent($question->getId()), 1, ',', ' '), $didyouknow);
        //}
        //$tpl->assignVar(array
        //(
            //'didyouknow_label' => $didyouknow,
            //'didyouknow_id'    => $question->getId(),
            //'didyouknow_guid'  => Tool::makeGuid($question->getLabel()),
        //));
    }
}

