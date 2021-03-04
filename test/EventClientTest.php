<?php

namespace Nitric\V1;

use Grpc\UnaryCall;
use PHPUnit\Framework\TestCase;
use stdClass;
use const Grpc\STATUS_OK;

class EventClientTest extends TestCase
{

    public function testPublish()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;
//        $mockStatusObj->details = "Mock Details";

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                null, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcEventClient = $this->createMock(\Nitric\BaseClient\V1\Events\EventClient::class);
        $stubGrpcEventClient
            ->expects($this->once())
            ->method('Publish')
//            ->with($this->objectHasAttribute('payload'))
            ->willReturn($stubUnaryCall);

        $events = new EventClient($stubGrpcEventClient);
        $requestId = $events->publish(
            topicName: "topic",
            payload: [
                "key" => "value",
            ],
            requestId: "abc-123");

        $this->assertEquals("abc-123", $requestId);
    }

    public function testAutomaticRequestId()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;
//        $mockStatusObj->details = "Mock Details";

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                null, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcEventClient = $this->createMock(\Nitric\BaseClient\V1\Events\EventClient::class);
        $stubGrpcEventClient
            ->expects($this->once())
            ->method('Publish')
//            ->with($this->objectHasAttribute('payload'))
            ->willReturn($stubUnaryCall);

        $events = new EventClient($stubGrpcEventClient);
        $requestId = $events->publish(
            topicName: "topic",
            payload: [
                "key" => "value",
            ]
        );

        $this->assertMatchesRegularExpression("/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/i", $requestId);
    }
}
