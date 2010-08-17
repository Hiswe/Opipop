<?php

class Block_Question_Map extends Block
{
    protected $_TEMPLATE = 'lib/view/question/map.tpl';

    private $question = null;

    private function getRandomColor()
    {
        if (rand(0,1))
        {
            $value1 = dechex(0);
            $value2 = dechex(rand(99, 255));
            $value3 = dechex(255);
        }
        else
        {
            $value1 = dechex(255);
            $value2 = dechex(0);
            $value3 = dechex(rand(99, 255));
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
            $colors[] = $this->getRandomColor();
            $values[] = rand(0, 100);
        }

        $this->tpl->assignVar(array(
            'map_regionColors' => json_encode($colors),
            'map_regionValues' => json_encode($values),
            'question_label'   => $this->question->getLabel(),
        ));
    }
}

