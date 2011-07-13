<?php

namespace Sfw\Controller;

class NoRoute extends ControllerAbstract
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