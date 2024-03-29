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

use Nitric\Proto\Faas\V1\HttpResponseContext as V1HttpResponseContext;

class HttpResponseContext extends ResponseContext
{
    public array $headers = [];
    public int $status = 200;

    public function __construct()
    {
    }

    /**
     * @return V1HttpResponseContext
     */
    public function toGrpcResponseContext(): V1HttpResponseContext
    {
        $grpcContext = new V1HttpResponseContext();
        $grpcContext->setHeaders($this->headers);
        $grpcContext->setStatus($this->status);

        return $grpcContext;
    }

    public function addHeader(string $key, string $val): HttpResponseContext
    {
        $this->headers[$key] = $val;
        return $this;
    }

    public function setStatus(int $status): HttpResponseContext
    {
        $this->status = $status;
        return $this;
    }
}
