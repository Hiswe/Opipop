<?php

class Remote_Propose_Submit extends Remote
{
    public $AJAXONLY = true;

    public function configureData()
    {
        // Insert submiton's info
        $id = DB::insert('INSERT INTO `submition` (`question`, `response1`, `response2`) VALUES
        (
            "' . $_POST['question'] . '",
            "' . $_POST['response1'] . '",
            "' . $_POST['response2'] . '"
        )');

        $_SESSION['feedback'] = 'Thank you for your submition !';
    }
}

