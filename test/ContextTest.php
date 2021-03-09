<?php

namespace Nitric\V1\Faas;

use PHPUnit\Framework\TestCase;

class ContextTest extends TestCase
{
    function testContextFromHeaders() {
        $headers = [
            "x-nitric-payload-type" => ["test payload type"],
            "x-nitric-request-id" => ["test id"],
            "x-nitric-source" => ["test source"],
            "x-nitric-source-type" => ["REQUEST"]
        ];
        $context = Context::fromHeaders($headers);
        $this->assertEquals("test payload type", $context->getPayloadType());
        $this->assertEquals("test id", $context->getRequestID());
        $this->assertEquals("test source", $context->getSource());
        $this->assertEquals("REQUEST", $context->getSourceType());
    }

    function testRequestSourceType() {
        $context = new Context("", "", "REQUEST", null);
        $this->assertEquals(SourceType::REQUEST, $context->getSourceType());
    }

    function testSubscriptionSourceType() {
        $context = new Context("", "", "SUBSCRIPTION", null);
        $this->assertEquals(SourceType::SUBSCRIPTION, $context->getSourceType());
    }

    function testUnknownSourceType() {
        $context = new Context("", "", "invalid source type", null);
        $this->assertEquals(SourceType::UNKNOWN, $context->getSourceType());
    }

    function testContextFromHeadersWithMissingKeys() {
        $headers = [
            // x-nitric keys are missing.
            "content-type" => ["text\/plain"]
        ];
        $context = Context::fromHeaders($headers);
        $this->assertEquals(null, $context->getPayloadType());
        $this->assertEquals(null, $context->getRequestID());
        $this->assertEquals(null, $context->getSource());
        $this->assertEquals("UNKNOWN", $context->getSourceType());
    }
}
