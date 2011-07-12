<?php

class Sfw_Controller_Table extends Sfw_Controller_Abstract
{
    public function render()
    {
        $table = $this->getRequest()->getParam('table');
        if (empty($table)) {
            throw new Exception('No table given.');
        }

        return sprintf(
            'table %s',
            $table
        );
    }
}