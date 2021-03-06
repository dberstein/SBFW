<?php

namespace SBFW\Controller;

class Table extends \SBFW\Controller
{
    public function render()
    {
        $table = trim(
            $this->getRequest()
                 ->getParam('table')
        );

        $page = $this->getPage();
        if (empty($table)) {
            $page->setRawHeader(
                sprintf(
                    '%s %d',
                    $_SERVER['SERVER_PROTOCOL'],
                    400
                )
            )->setPayload('No table given.');
        } else {
            $page->setPayload(
                sprintf(
                    'table [%s]',
                    htmlentities($table)
                )
            );
        }

        return $page;
    }
}