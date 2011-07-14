<?php

namespace Sfw;

use Sfw\Process\Pipes;

class Process
{
    protected $_command;
    protected $_pipes;

    public function __construct($command = null)
    {
        if (!is_null($command)) {
            $this->setCommand($command);
        }
    }

    public function setCommand($command)
    {
        $this->_command = $command;

        // Clear pipes
        $this->_pipes = array(
            \Sfw\Process\Pipes::STDIN => null,
            \Sfw\Process\Pipes::STDOUT => null,
            \Sfw\Process\Pipes::STDERR => null,
        );

        return $this;
    }

    public function getCommand()
    {
        return $this->_command;
    }

    public function execute($stdin = null, $cwd = null, $env = null)
    {
        $this->write(Process\Pipes::STDIN, $stdin);

        $spec = array(
            Process\Pipes::STDIN => array('pipe', 'r'),
            Process\Pipes::STDOUT => array('pipe', 'w'),
            Process\Pipes::STDERR => array('pipe', 'w'),
        );

        $resource = proc_open(
            $this->getCommand(),
            $spec,
            $pipes,
            $cwd,
            $env
        );

        if (!is_resource($resource)) {
            throw new \Exception(
                'No process created!'
            );
        }

        $return = fwrite(
            $pipes[Process\Pipes::STDIN],
            $this->_pipes[Process\Pipes::STDIN]
        );

        fflush($pipes[Process\Pipes::STDIN]);
        fclose($pipes[Process\Pipes::STDIN]);

        // Read command's STDOUT/STDERR
        $data = array(
            Process\Pipes::STDOUT => null,
            Process\Pipes::STDERR => null,
        );

        $processPipes = new Process\Pipes;
        foreach ($data as $fd => &$content) {
            $handle = $pipes[$fd];

            while (!feof($handle)) {
                $content .= fgetc($handle);
            }

            $processPipes->set($fd, $content);
        }

        $status = proc_close($resource);

        return new Process\Result($status, $processPipes);
    }

    protected function write($pipe, $data)
    {
        if (array_key_exists($pipe, $this->_pipes)) {
            $this->_pipes[$pipe] = $data;
        }

        return $this;
    }

    public function read($pipe, $default = null)
    {
        if (array_key_exists($pipe, $this->_pipes)) {
            $default = $this->_pipes[$pipe];
        }

        return $default;
    }
}