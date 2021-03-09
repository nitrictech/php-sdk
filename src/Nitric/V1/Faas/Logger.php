<?php


namespace Nitric\V1\Faas;


use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{

    private function doTheLogThing($message, array $context) {
        print "\n";
        print $message;
        print "\n";
        print json_encode($context);
    }

    public function emergency($message, array $context = array())
    {
        $this->doTheLogThing($message, $context);
    }

    public function alert($message, array $context = array())
    {
        $this->doTheLogThing($message, $context);
    }

    public function critical($message, array $context = array())
    {
        $this->doTheLogThing($message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->doTheLogThing($message, $context);
    }

    public function warning($message, array $context = array())
    {
        $this->doTheLogThing($message, $context);
    }

    public function notice($message, array $context = array())
    {
        $this->doTheLogThing($message, $context);
    }

    public function info($message, array $context = array())
    {
        $this->doTheLogThing($message, $context);
    }

    public function debug($message, array $context = array())
    {
        $this->doTheLogThing($message, $context);
    }

    public function log($level, $message, array $context = array())
    {
        $this->doTheLogThing($message, $context);
    }
}