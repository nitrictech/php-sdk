<?php

namespace Nitric\Faas;

use PHPUnit\Framework\TestCase;

/**
 * @covers Logger
 */
class LoggerTest extends TestCase
{
    function testContextInterpolation()
    {
        $context = [
            "prop" => "test"
        ];
        $message = "this is a {prop} and another {prop}";

        $processedMessage = Logger::interpolate($message, $context);
        $this->assertEquals("this is a test and another test", $processedMessage);
    }
}
