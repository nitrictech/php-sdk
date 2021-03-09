<?php

namespace Nitric\V1\Faas;

use PHPUnit\Framework\TestCase;

class FaasTest extends TestCase
{
    function testStart() {
        Faas::start(function ($request) {
            return new Response("testing the real response");
        });
    }

    function testFromHeaders() {
        $headerJson = '{"content-type":["text\/plain"],"user-agent":["PostmanRuntime\/7.26.8"],"accept":["*\/*"],"postman-token":["146fcc50-c24d-41f9-8094-e40b2f56c53f"],"host":["localhost:8080"],"accept-encoding":["gzip, deflate, br"],"connection":["keep-alive"],"content-length":["22"]}';
        $headers = [
            "content-type" => ["text\/plain"]
        ];
        $context = Context::fromHeaders($headers);
    }
}
