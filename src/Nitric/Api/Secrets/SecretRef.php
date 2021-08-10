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
use Nitric\ProtoUtils\Utils;
use Nitric\Proto\Secret\V1\Secret;
use Nitric\Proto\Secret\V1\SecretPutRequest;

class SecretRef
{

    private string $name;
    private Secrets $secrets;

    /**
     * SecretRef constructor.
     *
     * Should not be called directly, use Secrets().secret() instead.
     *
     * @param Secrets $secrets nested reference to the Secrets client
     * @param string $name Name of the secret reference
     */
    public function __construct(Secrets $secrets, string $name)
    {
        $this->name = $name;
        $this->secrets = $secrets;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * put
     *
     * Creates a new secret version with the provided secret value.
     *
     * @param string $value The secret value to store
     */
    public function put(string $value): SecretVersionRef
    {
        $spr = new SecretPutRequest();

        $spr->setSecret($this->toWire());
        $spr->setValue($value);

        [$resp, $status] = $this->secrets->_baseSecretClient->Put($spr)->wait();
        Utils::okOrThrow($status);

        return new SecretVersionRef(
            $this->secrets,
            $this,
            $resp->getSecretVersion()->getVersion(),
        );
    }

    /**
     * latest
     *
     * Creates a new secret version reference, referencing the latest version of the secret.
     */
    public function latest(): SecretVersionRef
    {
        return $this->version("latest");
    }

    /**
     * version
     *
     * Creates a new secret version reference with the provided secret version.
     *
     * @param string $version The secret version to create a reference to
     */
    public function version(string $version): SecretVersionRef
    {
        return new SecretVersionRef(
            $this->secrets,
            $this,
            $version,
        );
    }

    public function toWire(): Secret
    {
        $s = new Secret();

        $s->setName($this->name);

        return $s;
    }
}
