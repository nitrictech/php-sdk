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

use Exception;
use Google\Protobuf\Struct;
use Nitric\Api\Events;
use Nitric\Proto\Event\V1\EventPublishRequest;
use Nitric\Proto\Event\V1\NitricEvent;
use Nitric\ProtoUtils\Utils;

class TopicRef
{

    private string $name;
    private Events $events;

    /**
     * TopicRef constructor.
     *
     * Should not be called directly, use Events().topic() instead.
     *
     * @param Events $events nested reference to the Events client
     */
    public function __construct(Events $events, string $name)
    {
        $this->name = $name;
        $this->events = $events;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Publish an event/message to a topic, which can be subscribed to by other services.
     *
     * @param  array       $payload     content of the message to send
     * @param  string      $payloadType fully qualified name of the event payload type,
     *                                  e.g. io.nitric.example.customer.created
     * @param  string|null $id          a unique id, used to ensure idempotent processing of events.
     *                                  Defaults to a version 4 UUID.
     * @return string the request id on successful publish
     * @throws Exception
     */
    public function publish(array $payload = [], string $payloadType = "", string $id = null): string
    {
        $payloadStruct = new Struct();
        try {
            $payloadStruct->mergeFromJsonString(json_encode($payload));
        } catch (Exception $e) {
            throw new Exception("Failed to serialize payload. Details: " . $e->getMessage());
        }

        $event = new NitricEvent();
        $event->setPayload($payloadStruct);
        $event->setPayloadType($payloadType);
        $event->setId($id);

        $publishRequest = new EventPublishRequest();
        $publishRequest->setTopic($this->name);
        $publishRequest->setEvent($event);

        list($reply, $status) = $this->events->_baseEventClient->Publish($publishRequest)->wait();

        Utils::okOrThrow($status);
        return $id;
    }
}
