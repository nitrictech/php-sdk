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

namespace Nitric\Api\Events;

use stdClass;

/**
 * Class Event represents an event, sent via topics and subscriptions.
 * @see Events
 * @package Nitric\Api
 */
class Event
{
    private string $id;
    private array|stdClass|null $payload;
    private string $payloadType;

    public function __construct(array|stdClass $payload = null, string $payloadType = "", string $id = "")
    {
        if ($payload == null) {
            $payload = new stdClass();
        }
        $this->payload = $payload;
        $this->payloadType = $payloadType;
        $this->id = $id;
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
     * @return Event
     */
    public function setId(string $id): Event
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
     * @return Event
     */
    public function setPayload(array|stdClass|null $payload): Event
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
     * @return Event
     */
    public function setPayloadType(string $payloadType): Event
    {
        $this->payloadType = $payloadType;
        return $this;
    }
}
