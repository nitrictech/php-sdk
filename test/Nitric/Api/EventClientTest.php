<?php

namespace Nitric\Api;

use Exception;
use Grpc\UnaryCall;
use Nitric\Api\Exception\UnimplementedException;
use PHPUnit\Framework\TestCase;
use stdClass;

use function Amp\call;

use const Grpc\STATUS_OK;
use const Grpc\STATUS_UNIMPLEMENTED;

/**
 * @covers EventClient
 */
class EventClientTest extends TestCase
{

    public function testPublish()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                null, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcEventClient = $this->createMock(\Nitric\Proto\Event\V1\EventClient::class);
        $stubGrpcEventClient
            ->expects($this->once())
            ->method('Publish')
//            ->with($this->objectHasAttribute('payload'))
            ->willReturn($stubUnaryCall);

        $events = new EventClient($stubGrpcEventClient);
        $id = $events->publish(
            topicName: "topic",
            payload: [
                "key" => "value",
            ],
            id: "abc-123");

        $this->assertEquals("abc-123", $id);
    }

    public function testPublishGrpcError()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_UNIMPLEMENTED;
        
        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                null, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcEventClient = $this->createMock(\Nitric\Proto\Event\V1\EventClient::class);
        $stubGrpcEventClient
            ->expects($this->once())
            ->method('Publish')
            ->willReturn($stubUnaryCall);

        $events = new EventClient($stubGrpcEventClient);

        $this->expectException(UnimplementedException::class);
        $events->publish(
            topicName: "topic",
            payload: [
                "key" => "value",
            ],
            id: "abc-123");
    }

    public function testPublishException()
    {
        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willThrowException(new Exception("test exception"));

        $stubGrpcEventClient = $this->createMock(\Nitric\Proto\Event\V1\EventClient::class);
        $stubGrpcEventClient
            ->expects($this->once())
            ->method('Publish')
            ->willReturn($stubUnaryCall);

        $events = new EventClient($stubGrpcEventClient);

        $this->expectException(Exception::class);
        $id = $events->publish(
            topicName: "topic",
            payload: [
                "key" => "value",
            ],
            id: "abc-123");

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

        $stubGrpcEventClient = $this->createMock(\Nitric\Proto\Event\V1\EventClient::class);
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
