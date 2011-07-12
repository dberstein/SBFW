<?php

class Sfw_Controller_NoRoute extends Sfw_Controller_Abstract
{
    public function render()
    {
        if (!headers_sent()) {
            header(
                sprintf(
                    'HTTP/%s 404 Not Found',
                    $_SERVER['SERVER_PROTOCOL']
                )
            );
        }

        return <<<EOT
<html>
  <head>
    <title>Error</title>
  </head>
  <body>
    <h1>No route</h1>
  </body>
</html>
EOT;
    }
}