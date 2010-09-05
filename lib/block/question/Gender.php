<?php

class Block_Question_Gender extends Block
{
    protected $template = 'lib/view/question/gender.tpl';

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
        foreach (array_reverse($answers) as $key => $answer)
        {
            $dataMen[] = array
            (
                'value' => (Tool::percent($answer->getTotalMale(), $this->question->getTotalMale()) / 100) * 0.95 + 0.05,
                'color' => $colors[$key],
            );
        }
        foreach ($answers as $key => $answer)
        {
            Globals::$tpl->assignLoopVar('question_men', array
            (
                'key'     => $key,
                'label'   => $answer->getLabel(),
                'percent' => number_format(Tool::percent($answer->getTotalMale(), $this->question->getTotalMale()), 1, ',', ' '),
            ));
        }

        // Percent FEMALE
        foreach (array_reverse($answers) as $key => $answer)
        {
            $dataWomen[] = array
            (
                'value' => (Tool::percent($answer->getTotalFemale(), $this->question->getTotalFemale()) / 100) * 0.95 + 0.05,
                'color' => $colors[$key],
            );
        }
        foreach ($answers as $key => $answer)
        {
            Globals::$tpl->assignLoopVar('question_women', array
            (
                'key'     => $key,
                'label'   => $answer->getLabel(),
                'percent' => number_format(Tool::percent($answer->getTotalFemale(), $this->question->getTotalFemale()), 1, ',', ' '),
            ));
        }

        Globals::$tpl->assignVar('question_men_data', json_encode($dataMen));
        Globals::$tpl->assignVar('question_women_data', json_encode($dataWomen));
        Globals::$tpl->assignVar('question_label', $this->question->getLabel());
    }
}

