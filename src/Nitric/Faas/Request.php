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

use Amp\Http\Server\Request as ServerRequest;
use Nitric\Proto\Faas\V1\TriggerRequest;

/**
 * Class Request represents a normalized request in the Nitric runtime.
 * @package Nitric\Faas
 */
class Request
{
    private Context $context;
    private string $data;
    private string $mimeType;

    /**
     * Request constructor.
     *
     * @param Context $context
     * @param string  $payload
     * @param string  $path
     */
    public function __construct(Context $context, string $data, string $mimeType)
    {
        $this->context = $context;
        $this->data = $data;
        $this->mimeType = $mimeType;
    }

    /**
     * Return a Request from an NitricTriggerRequest
     * @param TriggerRequest $request
     * @return Request
     */
    public static function fromTriggerRequest(TriggerRequest $request): Request
    {
        $context = Context::fromTriggerRequest($request);

        return new Request(
            $context,
            $request->getData(),
            $request->getMimeType()
        );
    }

    /**
     * @return Context
     */
    public function getContext(): Context
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getDefaultResponse(): Response
    {
        $response = new Response();
        if ($this->context->isHttp()) {
            $response->setContext(ResponseContext::http());
        } elseif ($this->context->isTopic()) {
            $response->setContext(ResponseContext::topic());
        }

        return $response;
    }
}
