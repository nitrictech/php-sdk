<?php

namespace Nitric\Api;

use Exception;
use Grpc\UnaryCall;
use Nitric\Api\Events\Event;
use Nitric\Api\Exception\UnimplementedException;
use Nitric\Proto\Event\V1\EventPublishResponse;
use Nitric\Proto\Event\V1\EventServiceClient;
use Nitric\Proto\Event\V1\NitricTopic;
use Nitric\Proto\Event\V1\TopicServiceClient;
use Nitric\Proto\Event\V1\TopicListResponse;
use PHPUnit\Framework\TestCase;
use stdClass;

use function Amp\call;

use const Grpc\STATUS_OK;
use const Grpc\STATUS_UNIMPLEMENTED;

/**
 * @covers \Nitric\Api\Events
 */
class EventsTest extends TestCase
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
                # Reply
                (new EventPublishResponse())
                    ->setId("abc-123"),
                # Status
                $mockStatusObj
            ]);

        $stubGrpcEventClient = $this->createMock(EventServiceClient::class);
        $stubGrpcEventClient
            ->expects($this->once())
            ->method('Publish')
//            ->with($this->objectHasAttribute('payload'))
            ->willReturn($stubUnaryCall);

        $events = new Events($stubGrpcEventClient);
        $event = $events->topic("topic")->publish(
            (new Event())
                ->setPayload([
                    "key" => "value",
                ])
                ->setId("abc-123")
        );

        $this->assertEquals("abc-123", $event->getId());
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
                new EventPublishResponse(), # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcEventClient = $this->createMock(EventServiceClient::class);
        $stubGrpcEventClient
            ->expects($this->once())
            ->method('Publish')
            ->willReturn($stubUnaryCall);

        $events = new Events($stubGrpcEventClient);

        $this->expectException(UnimplementedException::class);
        $events->topic("topic")->publish(new Event());
    }

    public function testPublishException()
    {
        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willThrowException(new Exception("test exception"));

        $stubGrpcEventClient = $this->createMock(EventServiceClient::class);
        $stubGrpcEventClient
            ->expects($this->once())
            ->method('Publish')
            ->willReturn($stubUnaryCall);

        $events = new Events($stubGrpcEventClient);

        $this->expectException(Exception::class);
        $id = $events->topic("topic")->publish(new Event());
    }

    // Topic Tests ============================================================

    public function testListTopics()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $response = new TopicListResponse();
        $response->setTopics([
            (new NitricTopic())->setName('test-topic'),
            (new NitricTopic())->setName('test-topic2'),
        ]);

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                $response, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcTopicClient = $this->createMock(TopicServiceClient::class);
        $stubGrpcTopicClient
            ->expects($this->once())
            ->method('List')
//            ->with($this->objectHasAttribute('payload'))
            ->willReturn($stubUnaryCall);

        $events = new Events(topicClient: $stubGrpcTopicClient);

        $topics = $events->topics();
        $this->assertEquals(2, count($topics));
    }
}
