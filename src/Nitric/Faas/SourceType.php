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

abstract class SourceType
{
    public const REQUEST = "REQUEST";
    public const SUBSCRIPTION = "SUBSCRIPTION";
    public const UNKNOWN = "UNKNOWN";

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
