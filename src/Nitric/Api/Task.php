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

namespace Nitric\Api;

use stdClass;

/**
 * Class Task represents a task message to be sent or received via a queue.
 * @see QueueClient
 * @package Nitric\Api
 */
class Task
{
    private string $id;
    private array|stdClass|null $payload;
    private string $payloadType;
    private string|null $leaseID;

    public function __construct(
        array|stdClass $payload = null,
        string $payloadType = "",
        string $id = "",
        string $leaseId = null
    ) {
        $this->id = $id;
        $this->payload = $payload ?: new stdClass();
        $this->payloadType = $payloadType;
        $this->leaseID = $leaseId;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return array|stdClass
     */
    public function getPayload(): array|stdClass
    {
        return $this->payload;
    }

    /**
     * @param array|stdClass $payload
     */
    public function setPayload(array|stdClass $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getPayloadType(): string
    {
        return $this->payloadType;
    }

    /**
     * @param string $payloadType
     */
    public function setPayloadType(string $payloadType): void
    {
        $this->payloadType = $payloadType;
    }

    /**
     * @return string
     */
    public function getLeaseId(): string
    {
        return $this->leaseID;
    }

    /**
     * @param string $leaseID
     */
    public function setLeaseId(string $leaseID): void
    {
        $this->leaseID = $leaseID;
    }
}
