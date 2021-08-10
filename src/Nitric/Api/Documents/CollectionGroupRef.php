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

/**
 * Class CollectionRef represents a reference to a collection, which may or may not exist.
 *
 * Used to perform operations on the collection or the documents within it, such as queries.
 *
 * @package Nitric\Api\Documents
 */
class CollectionGroupRef
{
    private Documents $documents;
    private string $name;
    private CollectionGroupRef|null $parent;

    /**
     * @throws Exception
     */
    public function __construct(Documents $documents, string $name, CollectionGroupRef $parent = null)
    {
        $this->documents = $documents;
        $this->name = $name;
        $this->parent = $parent;
    }

    /**
     * Return a new QueryBuilder scoped to this collection.
     *
     * @return QueryBuilder
     */
    public function query(): QueryBuilder
    {
        return new QueryBuilder(
            $this->documents,
            $this->toCollectionRef()
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DocumentRef|null
     */
    public function getParent(): ?CollectionGroupRef
    {
        return $this->parent;
    }

    /**
     * @return CollectionRef
     */
    private function toCollectionRef(): CollectionRef
    {
        if ($this->getParent() != null) {
            return new CollectionRef(
                $this->documents,
                $this->name,
                new DocumentRef($this->documents, $this->getParent()->toCollectionRef(), "")
            );
        }


        return new CollectionRef($this->documents, $this->name);
    }

        /**
         *
         */
    public static function fromCollectionRef(CollectionRef $ref, Documents $client): CollectionGroupRef
    {
        if ($ref->getParent() != null) {
            return new CollectionGroupRef(
                $client,
                $ref->getName(),
                CollectionGroupRef::fromCollectionRef($ref->getParent()->getParent(), $client)
            );
        }

        return new CollectionGroupRef($client, $ref->getName());
    }
}
