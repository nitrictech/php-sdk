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

use InvalidArgumentException;
use Nitric\Api\Documents;
use Nitric\Api\Documents\Internal\WireAdapter;
use Nitric\Proto\Document\V1\Document;
use Nitric\Proto\Document\V1\DocumentQueryRequest;
use Nitric\Proto\Document\V1\DocumentQueryResponse;
use Nitric\Proto\Document\V1\Expression;
use Nitric\ProtoUtils\Utils;
use PhpParser\Node\Expr\Cast\Double;

class QueryBuilder
{
    protected Documents $documents;
    protected CollectionRef $collection;
    protected int $limit;
    protected array $expressions;
    protected mixed $pagingToken;

    public function __construct(Documents $documents, CollectionRef $collection)
    {
        $this->documents = $documents;
        $this->collection = $collection;
        $this->limit = 0;
        $this->expressions = array();
        $this->pagingToken = null;
    }

    /**
     * Set the maximum number of results to be returned.
     *
     * When paging, the limit applies to the total of all results across pages.
     *
     * @param int $limit
     * @return QueryBuilder
     */
    public function limit(int $limit): QueryBuilder
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Add an expression to the query used to filter the returned results.
     *
     * @param string|QueryExpression $operand the QueryExpresion to add or the operand for a new expression.
     * @param string $operator the QueryExpression operator, only used when the first argument is a string
     * @param int|double|string|bool $value the QueryExpression value, only used when the first argument is a string
     * @return QueryBuilder
     */
    public function where(string|QueryExpression $operand, string $operator = null, int|double|string|bool $value = null): QueryBuilder
    {
        $num_args = func_num_args();
        $args = func_get_args();

        if ($num_args == 1) {
            if ($args[0]::class == QueryExpression::class) {
                array_push($this->expressions, $args[0]);
            } else {
                throw new InvalidArgumentException("Expected single argument with type " .
                    QueryExpression::class . " found type " . $args[0]::class);
            }
        } elseif ($num_args == 3) {
            $expression = new QueryExpression($args[0], $args[1], $args[2]);
            array_push($this->expressions, $expression);
        } else {
            throw new InvalidArgumentException("Unexpected number of args");
        }

        return $this;
    }

    /**
     * Set the paging token returned from a previous query, used to return the next page in a subsequent query.
     *
     * @param null $paging_token
     * @return QueryBuilder
     */
    public function pageFrom($paging_token): QueryBuilder
    {
        $this->pagingToken = $paging_token;
        return $this;
    }

    public function fetch(): QueryResultsPage
    {
        $request = new DocumentQueryRequest();
        $request->setCollection(WireAdapter::collectionRefToWire($this->collection));
        $request->setLimit($this->limit);
        if ($this->pagingToken) {
            $request->setPagingToken($this->pagingToken);
        }
        $request->setExpressions(
            array_map(fn($exp): Expression => WireAdapter::expressionToWire($exp), $this->expressions)
        );

        [$response, $status] = $this->documents->_baseDocumentClient->Query($request)->wait();
        Utils::okOrThrow($status);
        $response = (fn($r): DocumentQueryResponse => $r)($response);

        $docs = Utils::mapRepeatedField(
            $response->getDocuments(),
            fn(Document $doc) => WireAdapter::docFromWire($this->documents, $doc)
        );

        $page = new QueryResultsPage(
            documents: $docs,
            pagingToken: $response->getPagingToken(),
        );
        return $page;
    }
}
