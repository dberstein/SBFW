<?php

namespace Sfw\Controller;

class Home extends ControllerAbstract
{
    public function render()
    {
        $page = $this->getPage();
        $page->setPayload('home');

        return $page;
    }
}