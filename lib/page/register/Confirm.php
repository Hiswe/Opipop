<?php

class Page_Register_Confirm extends Page
{
    public function configureView()
    {
        $this->tpl->assignTemplate('lib/view/header.tpl');
        $this->tpl->assignTemplate('lib/view/top.tpl');
        $this->tpl->assignTemplate('lib/view/register/confirm.tpl');
        $this->tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        $top = new Block_Top($this->tpl);
        $top->configure();

        $id  = $this->getParameter('u');
        $key = $this->getParameter('k');

        if (Tool::isOk($id) && Tool::isOk($key))
        {
            // If some user are connected
            if ($user = Model_User::getLoggedUser())
            {
                $this->tpl->assignSection('confirm_ok');
            }
            else
            {
                if (Model_User::isKeyValid($id, $key))
                {
                    Model_User::validateRegistration($id);
                    Model_User::login($id);

                    $this->tpl->assignSection('confirm_ok');
                }
                else
                {
                    $this->tpl->assignSection('confirm_error');
                }
            }
        }
        else
        {
            $this->tpl->assignSection('confirm_wait');
        }
    }
}

