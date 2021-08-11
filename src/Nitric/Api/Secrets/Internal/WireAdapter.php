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

namespace Nitric\Api\Secrets\Internal;

use Nitric\Api\Secrets\SecretRef;
use Nitric\Api\Secrets\SecretVersionRef;
use Nitric\Proto\Secret\V1\Secret;
use Nitric\Proto\Secret\V1\SecretVersion;

abstract class WireAdapter
{
    /**
     * @throws Exception
     */
    public static function secretVersionRefToWire(SecretVersionRef $value): SecretVersion
    {
        $sv = new SecretVersion();

        $sv->setSecret(WireAdapter::secretRefToWire($value->getParent()));
        $sv->setVersion($value->getVersion());

        return $sv;
    }

    /**
     * @throws Exception
     */
    public static function secretRefToWire(SecretRef $value): Secret
    {
        $s = new Secret();

        $s->setName($value->getName());

        return $s;
    }
}
