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

namespace Nitric\Api\Documents;

use Exception;
use Nitric\Api\Documents;
use Nitric\Api\Documents\Internal\WireAdapter;
use Nitric\Proto\Document\V1\DocumentDeleteRequest;
use Nitric\Proto\Document\V1\DocumentGetRequest;
use Nitric\Proto\Document\V1\DocumentGetResponse;
use Nitric\Proto\Document\V1\DocumentSetRequest;
use Nitric\ProtoUtils\Utils;
use stdClass;

class DocumentRef
{
    private Documents $documents;
    private string $id;
    private CollectionRef|null $parent;

    public function __construct(Documents $documents, CollectionRef $collection, string $id)
    {
        $this->documents = $documents;
        $this->id = $id;
        $this->parent = $collection;
    }


    /**
     * @throws Exception
     */
    public function collection(string $name): CollectionRef
    {
        return new CollectionRef(documents: $this->documents, name: $name, parent: $this);
    }

    /**
     * @throws Exception
     */
    public function get(): DocumentSnapshot
    {
        $request = new DocumentGetRequest();
        $request->setKey(WireAdapter::docRefToWireKey($this));

        [$response, $status] = $this->documents->_baseDocumentClient->Get($request)->wait();
        Utils::okOrThrow($status);
        $response = (fn($r): DocumentGetResponse => $r)($response);

        return WireAdapter::docFromWire($this->documents, $response->getDocument());
    }

    /**
     * Set the content of the document, if it doesn't exist it will be created.
     * @throws Exception
     */
    public function set(stdClass $content)
    {
        $request = new DocumentSetRequest();
        $request->setKey(WireAdapter::docRefToWireKey($this));
        $request->setContent(Utils::structFromClass($content));

        [$response, $status] = $this->documents->_baseDocumentClient->Set($request)->wait();
        Utils::okOrThrow($status);
    }

    /**
     * Delete the document referred to by this reference, if it exists.
     */
    public function delete()
    {
        $request = new DocumentDeleteRequest();
        $request->setKey(WireAdapter::docRefToWireKey($this));

        [$response, $status] = $this->documents->_baseDocumentClient->Delete($request)->wait();
        Utils::okOrThrow($status);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return CollectionRef|null
     */
    public function getParent(): ?CollectionRef
    {
        return $this->parent;
    }
}
