<?php

namespace Nitric\Api;

use Google\Protobuf\Struct;
use Grpc\UnaryCall;
use Nitric\Api\Queues\Task;
use Nitric\Proto\Queue\V1\FailedTask;
use Nitric\Proto\Queue\V1\NitricTask;
use Nitric\Proto\Queue\V1\QueueReceiveRequest;
use Nitric\Proto\Queue\V1\QueueReceiveResponse;
use Nitric\Proto\Queue\V1\QueueSendBatchRequest;
use Nitric\Proto\Queue\V1\QueueSendBatchResponse;
use Nitric\Proto\Queue\V1\QueueServiceClient;
use PHPUnit\Framework\TestCase;
use stdClass;
use const Grpc\STATUS_OK;

/**
 * @covers \Nitric\Api\Queues
 */
class QueuesTest extends TestCase
{
    public function testSendBatch()
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

        $stubGrpcQueueClient = $this->createMock(QueueServiceClient::class);
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

        $queues = new Queues($stubGrpcQueueClient);
        $resp = $queues->queue('test-queue')->sendBatch($tasks);
        // Assert no failed tasks were returned.
        $this->assertCount(0, $resp);
    }

    public function testReceive()
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

        $stubGrpcQueueClient = $this->createMock(QueueServiceClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('Receive')
            ->with($this->callback(function (QueueReceiveRequest $request) {
                return $request->getQueue() == "test-queue" && $request->getDepth() == 1;
            }))
            ->willReturn($stubUnaryCall);

        $queues = new Queues($stubGrpcQueueClient);
        $resp = $queues->queue("test-queue")->receive();
        $this->assertCount(1, $resp);
        [$task] = $resp;
        $this->assertEquals("1234", $task->getId());
        $this->assertEquals("5678", $task->getLeaseId());
        $this->assertEquals("test-payload", $task->getPayloadType());
        $this->assertCount(0, (array)$task->getPayload());
    }

    public function testSendBatchFailedTask()
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

        $stubGrpcQueueClient = $this->createMock(QueueServiceClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('SendBatch')
            ->willReturn($stubUnaryCall);

        $queues = new Queues(client: $stubGrpcQueueClient);
        $resp = $queues->queue("test-queue")->sendBatch([]);

        // By containing the failed task
        $this->assertCount(1, $resp);
        [$failedTask] = $resp;
        $this->assertEquals("1234", $failedTask->getTask()->getId());
        $this->assertEquals("it failed", $failedTask->getMessage());
    }

    public function testMinReceiveDepth()
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

        $stubGrpcQueueClient = $this->createMock(QueueServiceClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('Receive')
            ->with($this->callback(function (QueueReceiveRequest $request) {
                return $request->getDepth() == 1;
            }))
            ->willReturn($stubUnaryCall);

        $queues = new Queues($stubGrpcQueueClient);
        $resp = $queues->queue("test-queue")->receive(-2);
    }
}
