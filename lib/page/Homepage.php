<?php

class Page_Homepage extends Page
{
    public function configureView()
    {
        Globals::$tpl->assignTemplate('lib/view/header.tpl');
        Globals::$tpl->assignTemplate('lib/view/top.tpl');
        Globals::$tpl->assignTemplate('lib/view/question/active.tpl');
        Globals::$tpl->assignTemplate('lib/view/question/archive.tpl');
        Globals::$tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top block
        $top = new Block_Top();
        $top->configure();

        // Configure active block
        $active = new Block_Question_Active();
        $active->configure();

        // Configure archive block
        $archive = new Block_Question_Archive();
        $archive->configure();
    }
}

