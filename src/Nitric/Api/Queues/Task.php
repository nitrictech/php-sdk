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

use stdClass;

/**
 * Class Task represents a task message to be sent via a queue.
 * @see Queues
 * @package Nitric\Api
 */
class Task
{
    protected string $id;
    protected array|stdClass|null $payload;
    protected string $payloadType;


    public function __construct(
        array|stdClass $payload = null,
        string $payloadType = "",
        string $id = "",
    ) {
        $this->id = $id;
        $this->payload = $payload ?: new stdClass();
        $this->payloadType = $payloadType;
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
     * @return Task
     */
    public function setId(string $id): Task
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array|stdClass|null
     */
    public function getPayload(): array|stdClass|null
    {
        return $this->payload;
    }

    /**
     * @param array|stdClass|null $payload
     * @return Task
     */
    public function setPayload(array|stdClass|null $payload): Task
    {
        $this->payload = $payload;
        return $this;
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
     * @return Task
     */
    public function setPayloadType(string $payloadType): Task
    {
        $this->payloadType = $payloadType;
        return $this;
    }
}
