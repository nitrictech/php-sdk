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
class CollectionRef
{
    private Documents $documents;
    private string $name;
    private DocumentRef|null $parent;

    /**
     * @throws Exception
     */
    public function __construct(Documents $documents, string $name, DocumentRef $parent = null)
    {
        $this->documents = $documents;
        $this->name = $name;
        $this->parent = $parent;

        $depth = $this->getSubCollectionDepth();
        if ($depth > Documents::MAX_COLLECTION_DEPTH) {
            throw new Exception("sub-collections support to a depth of " .
                Documents::MAX_COLLECTION_DEPTH . " attempted to create a new collection with depth " . $depth);
        }
    }

    /**
     * Return a reference to a document in this collection.
     *
     * @param string $id unique id of the document within the collection.
     * @return DocumentRef a reference to the document, which may or may not exists.
     */
    public function doc(string $id): DocumentRef
    {
        return new DocumentRef($this->documents, $this, $id);
    }

    /**
     * Return a new QueryBuilder scoped to this collection.
     *
     * @return QueryBuilder
     */
    public function query(): QueryBuilder
    {
        return new QueryBuilder($this->documents, $this);
    }

    public function isSubCollection(): bool
    {
        return $this->parent != null;
    }

    /**
     * Returns the number of parent collections above this collection.
     *
     * @return int 0 if this is a root collection, + 1 for each parent collection above this one.
     */
    public function getSubCollectionDepth(): int
    {
        if (!$this->isSubCollection()) {
            return 0;
        }
        return $this->getParent()->getParent()->getSubCollectionDepth() + 1;
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
    public function getParent(): ?DocumentRef
    {
        return $this->parent;
    }
}
