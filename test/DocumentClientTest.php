<?php

namespace Nitric\V1;

use PHPUnit\Framework\TestCase;

class DocumentClientTest extends TestCase
{
    public function testCreateDocument()
    {
        $docs = new DocumentClient();
        $obj = new \stdClass();
        $obj->testing = "some value";
        $docs->create("welcomed", "test2", $obj);
        $this->assertTrue(true);
    }

    public function testGetDocument()
    {
        $docs = new DocumentClient();
        $obj = $docs->get("welcomed", "test2");
        $this->assertEquals("some value", $obj->testing);
    }
}
