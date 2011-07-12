<?php

class Sfw_Controller_NoRoute extends Sfw_Controller_Abstract
{
    public function render()
    {
        $page = $this->getPage();
        $page->setRawHeader(
            sprintf(
                '%s 404 Not Found',
                $_SERVER['SERVER_PROTOCOL']
            )
        );

        $page->setPayload(
        <<<EOT
<html>
  <head>
    <title>Error</title>
  </head>
  <body>
    <h1>No route</h1>
  </body>
</html>
EOT
        );

        return $page;
    }
}