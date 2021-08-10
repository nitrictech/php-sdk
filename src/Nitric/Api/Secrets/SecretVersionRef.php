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

use Exception;
use Google\Protobuf\Struct;
use Nitric\Api\Secrets;
use Nitric\Proto\Secret\V1\SecretVersion;
use Nitric\Proto\Secret\V1\SecretAccessRequest;
use Nitric\ProtoUtils\Utils;

class SecretVersionRef
{

    private SecretRef $parent;
    private string $version;
    private Secrets $secrets;

    /**
     * TopicRef constructor.
     *
     * Should not be called directly, use Events().topic() instead.
     *
     * @param Events $events nested reference to the Events client
     */
    public function __construct(Secrets $secrets, SecretRef $parent, string $version)
    {
        $this->version = $version;
                $this->parent = $parent;
        $this->secrets = $secrets;
    }


    /**
     * Retrieve parent SecretRef for this SecretVersionRef
     */
    public function getParent(): SecretRef
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    public function toWire(): SecretVersion
    {
        $sv = new SecretVersion();

        $sv->setSecret($this->parent->toWire());
        $sv->setVersion($this->version);

        return $sv;
    }


    public function access(): SecretValue
    {
        $sar = new SecretAccessRequest();

        $sar->setSecretVersion($this->toWire());

        [$resp, $status] = $this->secrets->_baseSecretClient->Access($sar)->wait();
        Utils::okOrThrow($status);

        return new SecretValue(
            new SecretVersionRef(
                $this->secrets,
                $this->parent,
                $resp->getSecretVersion()->getVersion(),
            ),
            $resp->getValue(),
        );
    }
}
