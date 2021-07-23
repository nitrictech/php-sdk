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

class QueryResultsPage
{
    private array $documents;
    private mixed $pagingToken;

    /**
     * QueryResultsPage constructor.
     *
     * @param DocumentSnapshot[] $documents
     * @param mixed $pagingToken
     */
    public function __construct(array $documents, mixed $pagingToken)
    {
        $this->documents = $documents;
        $this->pagingToken = $pagingToken;
    }

    /**
     * Return true if more pages are available from the query that returned this page.
     *
     * @return bool
     */
    public function hasMorePages(): bool
    {
        return $this->pagingToken != null;
    }

    /**
     * Return the array of documents returned in this page of query results.
     *
     * @return DocumentSnapshot[] the results
     */
    public function getDocuments(): array
    {
        return $this->documents;
    }

    /**
     * Retrieve the paging token from this page, if present.
     *
     * Used when making a request to retrieve a subsequent page of results.
     *
     * If null, this is the only/last page of results.
     *
     * @return mixed
     */
    public function getPagingToken(): mixed
    {
        return $this->pagingToken;
    }
}
