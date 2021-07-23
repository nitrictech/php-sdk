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

use Nitric\Api\Queues;
use Nitric\Proto\Queue\V1\QueueCompleteRequest;
use Nitric\ProtoUtils\Utils;
use stdClass;

/**
 * Class LeasedTask represents a task message to received via a queue with a temporary lease.
 * @see Queues
 * @package Nitric\Api
 */
class LeasedTask extends Task
{
    protected Queues $_queues;
    protected QueueRef $queue;
    protected string|null $leaseId;

    public function __construct(Queues $queues, QueueRef $queue, array|stdClass $payload = null, string $payloadType = "", string $id = "", string $leaseId = null)
    {
        parent::__construct($payload, $payloadType, $id);
        $this->_queues = $queues;
        $this->queue = $queue;
        $this->leaseId = $leaseId;
    }

    /**
     * Mark this task as complete, removing it from the queue to prevent reprocessing.
     */
    public function complete()
    {
        $request = new QueueCompleteRequest();

        $request->setQueue($this->queue->getName());
        $request->setLeaseId($this->leaseId);

        [$response, $status] = $this->_queues->_baseQueueClient->Complete($request);
        Utils::okOrThrow($status);
    }

    /**
     * @return string
     */
    public function getLeaseId(): string
    {
        return $this->leaseId;
    }
}
