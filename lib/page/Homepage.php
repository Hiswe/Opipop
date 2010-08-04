<?php

class Page_Homepage extends Page
{
    public function configureView()
    {
        $this->tpl->assignTemplate('lib/view/header.tpl');
        $this->tpl->assignTemplate('lib/view/top.tpl');
        $this->tpl->assignTemplate('lib/view/question/active.tpl');
        $this->tpl->assignTemplate('lib/view/question/archive.tpl');
        $this->tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top block
        $top = new Block_Top($this->tpl);
        $top->configure();

        // Configure active block
        $active = new Block_Question_Active($this->tpl);
        $active->configure();

        // Configure archive block
        $archive = new Block_Question_Archive($this->tpl);
        $archive->configure();
    }
}

