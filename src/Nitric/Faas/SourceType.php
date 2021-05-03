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
 * Class SourceType represents the source type of a request such as HTTP Requests and Subscription Events.
 * @package Nitric\Faas
 */
abstract class SourceType
{
    /**
     * HTTP Request source type
     */
    public const REQUEST = "REQUEST";
    /**
     * Event source type
     */
    public const SUBSCRIPTION = "SUBSCRIPTION";
    /**
     * Unknown source type
     */
    public const UNKNOWN = "UNKNOWN";

    /**
     * Parse a SourceType from a string representation. Supported values are:
     * REQUEST & SUBSCRIPTION, all other values will return UNKNOWN.
     * @param $sourceType
     * @return string
     */
    public static function fromString($sourceType)
    {
        $sourceType = strtoupper($sourceType);
        return match ($sourceType) {
            self::REQUEST => self::REQUEST,
            self::SUBSCRIPTION => self::SUBSCRIPTION,
            default => self::UNKNOWN,
        };
    }
}
