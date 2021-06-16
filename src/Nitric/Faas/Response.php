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

namespace Nitric\Faas;

use Nitric\Proto\Faas\V1\HttpResponseContext;
use Nitric\Proto\Faas\V1\HttpTriggerContext;
use Nitric\Proto\Faas\V1\TriggerRequest;
use Nitric\Proto\Faas\V1\TriggerResponse;

/**
 * Class Response represents a normalized response in the Nitric runtime. Will be converted to a specific response type
 * such as an HTTP response, depending on runtime environment.
 * @package Nitric\Faas
 */
class Response
{
    private ResponseContext $context;
    private string $data;

    /**
     * @return Response
     */
    public function setData(string $data): Response
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return Response
     */
    public function setContext(ResponseContext $context): Response
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @return Response
     */
    public function getContext(): ResponseContext
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        if ($this->data == null) {
            return "";
        }
        return $this->data;
    }

    public function toTriggerResponse(): TriggerResponse
    {
        $triggerResponse = new TriggerResponse();
        $triggerResponse->setData($this->data);

        if ($this->context->isHttp()) {
            $origContext = $this->getContext()->asHttp();

            $triggerResponse->setHttp($origContext->toGrpcResponseContext());
        } elseif ($this->context->isTopic()) {
            $origContext = $this->getContext()->asTopic();

            $triggerResponse->setTopic($origContext->toGrpcResponseContext());
        }

        return $triggerResponse;
    }
}
