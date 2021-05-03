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
 * Class Context represents the metadata of a FaaS request, including the source, payload type, unique request Id, etc.
 * @package Nitric\Faas
 */
class Context
{
    private string|null $requestID;
    private string|null $source;
    private string $sourceType;
    private string|null $payloadType;

    /**
     * Context constructor.
     *
     * @param string|null $requestID
     * @param string|null $source
     * @param string      $sourceType
     * @param string|null $payloadType
     */
    public function __construct(
        string|null $requestID,
        string|null $source,
        string $sourceType,
        string|null $payloadType
    ) {
        $this->requestID = $requestID;
        $this->source = $source;
        $this->sourceType = SourceType::fromString($sourceType);
        $this->payloadType = $payloadType;
    }

    private static function getValueIfExists($array, $key)
    {
        return isset($array[$key]) ? $array[$key][0] : null;
    }

    public static function fromHeaders(array $headers): Context
    {
        $requestId = self::getValueIfExists($headers, "x-nitric-request-id");
        $sourceType = self::getValueIfExists($headers, "x-nitric-source-type") ?: "UNKNOWN";
        $source =  self::getValueIfExists($headers, "x-nitric-source");
        $payloadType = self::getValueIfExists($headers, "x-nitric-payload-type");

        return new Context(
            $requestId,
            $source,
            $sourceType,
            $payloadType
        );
    }

    /**
     * @return string
     */
    public function getRequestID(): string|null
    {
        return $this->requestID;
    }

    /**
     * @param string $requestID
     */
    public function setRequestID(string|null $requestID): void
    {
        $this->requestID = $requestID;
    }

    /**
     * @return string
     */
    public function getSource(): string|null
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string|null $source): void
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getSourceType(): string
    {
        return $this->sourceType;
    }

    /**
     * @param string $sourceType
     */
    public function setSourceType(string $sourceType): void
    {
        $this->sourceType = SourceType::fromString($sourceType);
    }

    /**
     * @return string
     */
    public function getPayloadType(): string|null
    {
        return $this->payloadType;
    }

    /**
     * @param string $payloadType
     */
    public function setPayloadType(string|null $payloadType): void
    {
        $this->payloadType = $payloadType;
    }
}
