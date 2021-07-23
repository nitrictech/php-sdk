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
use Nitric\Api\Documents\CollectionRef;
use Nitric\Proto\Document\V1\DocumentServiceClient;
use Nitric\ProtoUtils\Utils;

/**
 * Class Documents provides a client for the Nitric Document Service.
 *
 * @category Sdk
 * @package Nitric\Api
 * @author   Nitric <maintainers@nitric.io>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://nitric.io
 */
class Documents
{
    public DocumentServiceClient $_baseDocumentClient;
    public const MAX_COLLECTION_DEPTH = 1;

    public function __construct(DocumentServiceClient $documentClient = null)
    {
        if ($documentClient) {
            $this->_baseDocumentClient = $documentClient;
        } else {
            $connection = Utils::connection();
            $this->_baseDocumentClient = new DocumentServiceClient($connection['hostname'], $connection['opts']);
        }
    }

    /**
     * Return reference to a collection from the document service. The collection may or may not exist.
     *
     * @param string $name
     * @return CollectionRef
     * @throws Exception
     */
    public function collection(string $name): CollectionRef
    {
        return new CollectionRef(documents: $this, name: $name);
    }
}
