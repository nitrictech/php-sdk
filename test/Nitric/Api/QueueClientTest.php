<?php

namespace Nitric\Api;

use Google\Protobuf\Struct;
use Grpc\UnaryCall;
use Nitric\Proto\Queue\V1\FailedTask;
use Nitric\Proto\Queue\V1\QueueReceiveRequest;
use Nitric\Proto\Queue\V1\QueueReceiveResponse;
use Nitric\Proto\Queue\V1\QueueSendBatchRequest;
use Nitric\Proto\Queue\V1\QueueSendBatchResponse;
use Nitric\Proto\Queue\V1\NitricTask;
use PHPUnit\Framework\TestCase;
use const Grpc\STATUS_OK;
use PHPUnit\Framework\Constraint\Constraint;
use stdClass;

/**
 * @covers QueueClient
 */
class QueueClientTest extends TestCase
{

    function testSendBatch()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $testResponse = new QueueSendBatchResponse();
        $testResponse->setFailedTasks([]);

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                $testResponse, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcQueueClient = $this->createMock(\Nitric\Proto\Queue\V1\QueueClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('SendBatch')
            ->with($this->callback(function (QueueSendBatchRequest $request) {
                return count($request->getTasks()) == 1;
            }))
            ->willReturn($stubUnaryCall);

        $tasks = [
            new Task()
        ];

        $queues = new QueueClient($stubGrpcQueueClient);
        $resp = $queues->sendBatch("test-queue", $tasks);
        // Assert no failed tasks were returned.
        $this->assertCount(0, $resp);
    }

    function testReceive()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $testTask = new NitricTask();
        $testTask
            ->setId("1234")
            ->setPayload(new Struct())
            ->setPayloadType("test-payload")
            ->setLeaseId("5678");

        $testResponse = new QueueReceiveResponse();
        $testResponse->setTasks([$testTask]);

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                $testResponse, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcQueueClient = $this->createMock(\Nitric\Proto\Queue\V1\QueueClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('Receive')
            ->with($this->callback(function (QueueReceiveRequest $request) {
                return $request->getQueue() == "test-queue" && $request->getDepth() == 1;
            }))
            ->willReturn($stubUnaryCall);

        $queues = new QueueClient($stubGrpcQueueClient);
        $resp = $queues->receive("test-queue");
        $this->assertCount(1, $resp);
        [$task] = $resp;
        $this->assertEquals("1234", $task->getId());
        $this->assertEquals("5678", $task->getLeaseId());
        $this->assertEquals("test-payload", $task->getPayloadType());
        $this->assertCount(0, (array)$task->getPayload());
    }

    function testSendBatchFailedTask()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;
        
        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                (new QueueSendBatchResponse())
                ->setFailedTasks([
                    (new FailedTask())
                        ->setMessage("it failed")
                        ->setTask((new NitricTask())
                            ->setId("1234")
                            ->setPayloadType("test-payload")
                            ->setPayload(new Struct()))
                ]), # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcQueueClient = $this->createMock(\Nitric\Proto\Queue\V1\QueueClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('SendBatch')
            ->willReturn($stubUnaryCall);

        $queues = new QueueClient($stubGrpcQueueClient);
        $resp = $queues->sendBatch("test-queue", []);

        // By containing the failed task
        $this->assertCount(1, $resp);
        [$failedTask] = $resp;
        $this->assertEquals("1234", $failedTask->getTask()->getId());
        $this->assertEquals("it failed", $failedTask->getMessage());
    }

    function testMinReceiveDepth()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                new QueueReceiveResponse(), # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcQueueClient = $this->createMock(\Nitric\Proto\Queue\V1\QueueClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('Receive')
            ->with($this->callback(function (QueueReceiveRequest $request) {
                return $request->getDepth() == 1;
            }))
            ->willReturn($stubUnaryCall);

        $queues = new QueueClient($stubGrpcQueueClient);
        $resp = $queues->receive("test-queue", -2);
    }
}
