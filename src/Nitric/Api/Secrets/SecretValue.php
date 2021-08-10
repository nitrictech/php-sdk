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

namespace Nitric\Api\Secrets;

class SecretValue
{

    private SecretVersionRef $version;
    private string $value;

    /**
     * TopicRef constructor.
     *
     * Should not be called directly, use Events().topic() instead.
     *
     * @param Events $events nested reference to the Events client
     */
    public function __construct(SecretVersionRef $version, string $value)
    {
        $this->version = $version;
                $this->value = $value;
    }

    /**
     * @return string
     */
    public function getVersion(): SecretVersionRef
    {
        return $this->version;
    }


    public function value(): string
    {
        return $this->value;
    }
}
