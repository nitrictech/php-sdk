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

use Nitric\Api\Secrets;
use Nitric\Api\Secrets\Internal\WireAdapter;
use Nitric\Proto\Secret\V1\SecretVersion;
use Nitric\Proto\Secret\V1\SecretAccessRequest;
use Nitric\ProtoUtils\Utils;

class SecretVersionRef
{

    private SecretRef $parent;
    private string $version;
    private Secrets $secrets;

    /**
     * SecretVersionRef constructor.
     *
     * Should not be called directly, use Secrets().secret().version() instead.
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

    /**
     * @return SecretValue - The value of the secret held by this secret version
     */
    public function access(): SecretValue
    {
        $sar = new SecretAccessRequest();
        $sar->setSecretVersion(WireAdapter::secretVersionRefToWire($this));

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
