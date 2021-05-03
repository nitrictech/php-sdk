<?php

/**
 * Copyright 2021-2021 Nitric Pty Ltd.
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

use Nitric\Proto\Event\V1\NitricTopic;
use Nitric\Proto\Event\V1\TopicClient as GrpcClient;
use Nitric\Proto\Event\V1\TopicListRequest;
use Nitric\Proto\Event\V1\TopicListResponse;

/**
 * Class TopicClient provides a client for the Nitric Topic Service.
 * @package Nitric\Api
 */
class TopicClient extends AbstractClient
{
    private GrpcClient $client;

    /**
     * TopicClient constructor.
     *
     * @param GrpcClient|null $client the autogenerated gRPC client object. Typically only injected for mocked testing.
     */
    public function __construct(GrpcClient $client = null)
    {
        parent::__construct();
        if ($client) {
            $this->client = $client;
        } else {
            $this->client = new GrpcClient($this->hostname, $this->opts);
        }
    }

    /**
     * Return a list of topics available for publishing or subscriptions.
     *
     * @return string[] array of topic names
     * @throws \Exception
     */
    public function list(): array
    {
        [$response, $status] = $this->client->List(new TopicListRequest())->wait();
        $this->okOrThrow($status);
        $response = (fn ($r): TopicListResponse => $r)($response);

        return array_map(
            function (NitricTopic $t): string {
                return $t->getName();
            },
            (array)$response->getTopics()
        );
    }
}
