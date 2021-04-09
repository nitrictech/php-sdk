<?php


namespace Nitric\Faas;


use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{
    static function interpolate($message, $context): string {
        $contextTokens = array();
        foreach ($context as $k => $v) {
            $contextTokens["{" . $k . "}"] = print_r($v, true);
        }
        return strtr($message, $contextTokens);
    }

    public function log($level, $message, array $context = array())
    {
        $mergedMessage = self::interpolate($message, $context);
        $exception = isset($context['exception']) ?  $context['exception'] . "\n" : "";
        printf("%s: %s\n%s", $level, $mergedMessage, $exception);
    }
}