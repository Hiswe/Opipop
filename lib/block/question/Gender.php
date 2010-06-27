<?php

class Block_Question_Gender extends Block
{
    protected $_TEMPLATE = 'lib/view/question/gender.tpl';

    private $question = null;

    public function setQuestion($question)
    {
        $this->question = $question;
    }

    public function configure()
    {
        // Get answers
        $answers = $this->question->getAnswers();

        $colors    = Conf::get('GRAPH_COLORS');
        $dataWomen = array();
        $dataMen   = array();

        // Percent MALE
        foreach ($answers as $key => $answer)
        {
            $dataMen[] = array
            (
                'value' => Tool::percent($answer->getTotalMale(), $this->question->getTotalMale()) / 100,
                'color' => $colors[$key],
            );
        }

        // Percent FEMALE
        foreach ($answers as $key => $answer)
        {
            $dataWomen[] = array
            (
                'value' => Tool::percent($answer->getTotalFemale(), $this->question->getTotalFemale()) / 100,
                'color' => $colors[$key],
            );
        }

        $this->tpl->assignVar('question_women_data', json_encode($dataWomen));
        $this->tpl->assignVar('question_men_data', json_encode($dataMen));
    }
}

