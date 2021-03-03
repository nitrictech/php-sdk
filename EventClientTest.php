<?php

namespace Nitric\V1;

use PHPUnit\Framework\TestCase;

class EventClientTest extends TestCase
{

    public function testPublish()
    {
        $events = new EventClient();
        $requestId = $events->publish("topic", [
            "key" => "value",
        ]);
        $this->assertMatchesRegularExpression("/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/i", $requestId);
    }
}
