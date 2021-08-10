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

namespace Nitric\Api;

use Exception;
use Nitric\Api\Secrets\SecretRef;
use Nitric\Proto\Secret\V1\SecretServiceClient;
use Nitric\ProtoUtils\Utils;

/**
 * Class Secrets provides a client for the Nitric Secret Service.
 *
 * @category Sdk
 * @package  Nitric\Api
 * @author   Nitric <maintainers@nitric.io>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://nitric.io
 */
class Secrets
{
    public SecretServiceClient $_baseSecretClient;

    public function __construct(SecretServiceClient $secretsClient = null)
    {
        if ($secretsClient) {
            $this->_baseSecretClient = $secretsClient;
        } else {
            $connection = Utils::connection();
            $this->_baseSecretClient = new SecretServiceClient($connection['hostname'], $connection['opts']);
        }
    }

    /**
     * Return reference to a secret from the secret service. The secret may or may not exist.
     *
     * @param string $name
     * @return SecretRef
     * @throws Exception
     */
    public function secret(string $name): SecretRef
    {
        return new SecretRef(secrets: $this, name: $name);
    }
}
