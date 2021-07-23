<?php

/**
 * Copyright 2021 Nitric Technologies Pty Ltd.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Nitric\Api\Queues;

use Exception;
use Nitric\Api\Queues;
use Nitric\Proto\Queue\V1\NitricTask;
use Nitric\Proto\Queue\V1\QueueReceiveRequest;
use Nitric\Proto\Queue\V1\QueueReceiveResponse;
use Nitric\Proto\Queue\V1\QueueSendBatchRequest;
use Nitric\Proto\Queue\V1\QueueSendBatchResponse;
use Nitric\Proto\Queue\V1\QueueSendRequest;
use Nitric\ProtoUtils\Utils;

class QueueRef
{

    private string $name;
    private Queues $queues;

    /**
     * QueueRef constructor.
     *
     * Should not be called directly, use Queues().queue() instead.
     *
     * @param Queues $queues nested reference to the Events client
     * @param string $name the queue name for this reference
     */
    public function __construct(Queues $queues, string $name)
    {
        $this->name = $name;
        $this->queues = $queues;
    }

    /**
     * Convert the API class representing a task to the protobuf class
     *
     * @param Task $task
     * @return NitricTask
     * @throws Exception
     */
    private static function taskToWire(Task $task): NitricTask
    {
        $ne = new NitricTask();
        $ne->setPayload(
            Utils::structFromClass($task->getPayload())
        );
        $ne->setPayloadType($task->getPayloadType());
        $ne->setId($task->getId());

        return $ne;
    }

    /**
     * Send a task to a queue, which can be received by other services.
     *
     * @param Task $task the task to push to the queue
     * @throws Exception
     */
    public function send(Task $task)
    {
        $request = new QueueSendRequest();
        $request->setQueue($this->name);

        $request->setTask(self::taskToWire($task));

        [$response, $status] = $this->queues->_baseQueueClient->Send($request)->wait();
        Utils::okOrThrow($status);
    }

    /**
     * Send a collection of tasks to a queue, which can be received by other services.
     *
     * @param Task[] $tasks The tasks to push to the queue
     * @return FailedTask[] containing a list containing details of any messages that failed to publish.
     * @throws Exception
     */
    public function sendBatch(array $tasks): array
    {
        $request = new QueueSendBatchRequest();
        $request->setQueue($this->name);

        $nitricTasks = array_map(
            function (Task $task) {
                return self::taskToWire($task);
            },
            $tasks
        );

        $request->setTasks($nitricTasks);

        [$response, $status] = $this->queues->_baseQueueClient->SendBatch($request)->wait();
        Utils::okOrThrow($status);
        // Add type hint to the response object
        $response = (fn($r): QueueSendBatchResponse => $r)($response);

        $failed = Utils::mapRepeatedField(
            $response->getFailedTasks(),
            function (\Nitric\Proto\Queue\V1\FailedTask $t) {
                $task = new Task();
                $task->setId($t->getTask()->getId());
                $task->setPayloadType($t->getTask()->getPayloadType());
                $task->setPayload(Utils::classFromStruct($t->getTask()->getPayload()));

                $failedTask = new FailedTask();
                $failedTask->setMessage($t->getMessage());
                $failedTask->setTask($task);
                return $failedTask;
            }
        );

        return $failed;
    }

    /**
     * Pop 1 or more items from the specified queue up to the depth limit.
     *
     * Received Tasks are leased for a limited period of time, where they may be worked on.
     * Once complete or failed they must be completed using the request specific leaseId.
     *
     * If the lease on a task expires before it is completed or the lease is extended the task will be
     * returned to the queue for reprocessing or forwarded to a dead-letter queue if retries have been exceeded.
     *
     * @param int $depth The maximum number of queue items to return. Default: 1, Min: 1.
     * @return LeasedTask[] Queue items popped from the queue.
     * @throws Exception
     */
    public function receive(int $depth = 1): array
    {
        if ($depth < 1) {
            $depth = 1;
        }
        $request = new QueueReceiveRequest();
        $request->setQueue($this->name);
        $request->setDepth($depth);

        [$response, $status] = $this->queues->_baseQueueClient->Receive($request)->wait();
        Utils::okOrThrow($status);
        $response = (fn($r): QueueReceiveResponse => $r)($response);


        return array_map(
            function (NitricTask $i) {
                return new LeasedTask(
                    queues: $this->queues,
                    queue: $this,
                    payload: Utils::classFromStruct($i->getPayload()),
                    payloadType: $i->getPayloadType(),
                    id: $i->getId(),
                    leaseId: $i->getLeaseId()
                );
            },
            [...$response->getTasks()]
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
