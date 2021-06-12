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

use Nitric\Faas\Context;

class HttpContext extends Context
{
    private string $method;
    private array $headers;
    private array $queryParams;
    private array $pathParams;

    public function __construct(
        string $method,
        array $headers,
        array $queryParams,
        array $pathParams
    ) {
        $this->method = $method;
        $this->headers = $headers;
        $this->queryParams = $queryParams;
        $this->pathParams = $pathParams;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getPathParams()
    {
        return $this->pathParams;
    }
}