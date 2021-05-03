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

namespace Nitric\Faas;

/**
 * Class Request represents a normalized request in the Nitric runtime.
 * @package Nitric\Faas
 */
class Request
{
    private Context $context;
    private string $payload;
    private string $path;

    /**
     * Request constructor.
     *
     * @param Context $context
     * @param string  $payload
     * @param string  $path
     */
    public function __construct(Context $context, string $payload, string $path)
    {
        $this->context = $context;
        $this->payload = $payload;
        $this->path = $path;
    }


    /**
     * Return a Request from an HTTP request using standard conventions. Used when FaaS services is operating as
     * an HTTP server.
     * @param array $headers
     * @param string $payload
     * @param string $path
     * @return Request
     */
    public static function fromHTTPRequest(array $headers, string $payload, string $path): Request
    {
        $context = Context::fromHeaders($headers);

        return new Request(
            context:  $context,
            payload: $payload,
            path: $path
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
     * @param Context $context
     */
    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload(string $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }
}
