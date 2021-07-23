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
use Nitric\Proto\Event\V1\EventPublishResponse;
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
     * @param Event $event
     * @return Event
     * @throws Exception
     */
    public function publish(Event $event): Event
    {
        $payloadStruct = new Struct();
        try {
            $payloadStruct->mergeFromJsonString(json_encode($event->getPayload()));
        } catch (Exception $e) {
            throw new Exception("Failed to serialize payload. Details: " . $e->getMessage());
        }

        $eventMessage = (new NitricEvent())
            ->setPayload($payloadStruct)
            ->setPayloadType($event->getPayloadType())
            ->setId($event->getId());

        $publishRequest = (new EventPublishRequest())
            ->setTopic($this->name)
            ->setEvent($eventMessage);

        list($response, $status) = $this->events->_baseEventClient->Publish($publishRequest)->wait();
        $response = (fn($r): EventPublishResponse => $r)($response);

        Utils::okOrThrow($status);
        $event->setId($response->getId());
        return $event;
    }
}
