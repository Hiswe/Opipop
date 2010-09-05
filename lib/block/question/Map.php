<?php

class Block_Question_Map extends Block
{
    protected $template = 'lib/view/question/map.tpl';

    private $question = null;

    private function getRandomColor($value, $color)
    {
        $value /= 100;
        $value = 1 - $value;

        switch($color)
        {
            case 0: // 0099FF
                $value1 = dechex(255 * $value);
                $value2 = dechex(153 + ((255 - 153) * $value));
                $value3 = dechex(255);
                break;

            case 1: // FF0099
                $value1 = dechex(255);
                $value2 = dechex(255 * $value);
                $value3 = dechex(153 + ((255 - 153) * $value));
                break;
        }

        $color = '#';
        $color .= (strlen($value1) < 2) ? '0' . $value1 : $value1;
        $color .= (strlen($value2) < 2) ? '0' . $value2 : $value2;
        $color .= (strlen($value3) < 2) ? '0' . $value3 : $value3;

        return $color;
    }

    public function setQuestion($question)
    {
        $this->question = $question;
    }

    public function configure()
    {
        $regions = array
        (
            'Alsace',
            'Aquitaine',
            'Auvergne',
            'Basse-Normandie',
            'Bourgogne',
            'Bretagne',
            'Centre',
            'Champagne-Ardenne',
            'Corse',
            'Franche-Comté',
            'Haute-Normandie',
            'Île-de-France',
            'Languedoc-Roussillon',
            'Limousin',
            'Lorraine',
            'Midi-Pyrénées',
            'Nord-Pas-de-Calais',
            'Pays de la Loire',
            'Picardie',
            'Poitou-Charentes',
            'Provence-Alpes-Côte d\'Azur',
            'Rhône-Alpes',
        );

        $colors = array();
        $values = array();
        foreach ($regions as $region)
        {
            $v = rand(0, 100);
            $colors[] = $this->getRandomColor($v, rand(0,1));
            $values[] = $v;
        }

        Globals::$tpl->assignVar(array(
            'map_regionColors' => json_encode($colors),
            'map_regionValues' => json_encode($values),
            'question_label'   => $this->question->getLabel(),
        ));

        // Get answers
        $answers = $this->question->getAnswers();

        foreach ($answers as $key => $answer)
        {
            Globals::$tpl->assignLoopVar('answer', array
            (
                'key'     => $key,
                'label'   => $answer->getLabel(),
                'percent' => number_format(Tool::percent($answer->getTotal(), $this->question->getTotal()), 1, ',', ' '),
            ));
        }
    }
}

