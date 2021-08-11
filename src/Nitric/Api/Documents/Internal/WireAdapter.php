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

namespace Nitric\Api\Documents\Internal;

use InvalidArgumentException;
use Nitric\Api\Documents;
use Nitric\Api\Documents\CollectionRef;
use Nitric\Api\Documents\DocumentRef;
use Nitric\Api\Documents\DocumentSnapshot;
use Nitric\Api\Documents\QueryExpression;
use Nitric\Proto\Document\V1\Collection;
use Nitric\Proto\Document\V1\Document;
use Nitric\Proto\Document\V1\Expression;
use Nitric\Proto\Document\V1\ExpressionValue;
use Nitric\Proto\Document\V1\Key;
use Nitric\ProtoUtils\Utils;

abstract class WireAdapter
{

    /**
     * @throws Exception
     */
    public static function docRefToWireKey(DocumentRef $ref): Key
    {
        $key = new Key();
        $key->setId($ref->getId());
        $key->setCollection(self::collectionRefToWire($ref->getParent()));
        return $key;
    }

    /**
     * @throws Exception
     */
    public static function collectionRefToWire(CollectionRef $ref): Collection
    {
        $collection = new Collection();
        $collection->setName($ref->getName());
        if ($ref->isSubCollection()) {
            $collection->setParent(self::docRefToWireKey($ref->getParent()));
        }
        return $collection;
    }

    /**
     * @throws Exception
     */
    public static function expressionToWire(QueryExpression $expression): Expression
    {
        $valMessage = self::expValueToWire($expression->getValue());

        $expMessage = new Expression();
        $expMessage->setOperand($expression->getOperand());
        $expMessage->setOperator($expression->getOperator());
        $expMessage->setValue($valMessage);
        return $expMessage;
    }

    /**
     * @throws Exception
     */
    public static function expValueToWire($value): ExpressionValue
    {
        $valueMessage = new ExpressionValue();
        if (is_int($value)) {
            $valueMessage->setIntValue($value);
        } elseif (is_double($value)) {
            $valueMessage->setDoubleValue($value);
        } elseif (is_string($value)) {
            $valueMessage->setStringValue($value);
        } elseif (is_bool($value)) {
            $valueMessage->setBoolValue($value);
        } else {
            throw new InvalidArgumentException("Unsupported type " . gettype($value) .
                ", supported types are int, double, string and bool.");
        }
        return $valueMessage;
    }

    /**
     * @throws Exception
     */
    public static function docFromWire(Documents $docsClient, Document $docMessage): DocumentSnapshot
    {
        return new DocumentSnapshot(
            ref: self::docRefFromWire($docsClient, $docMessage->getKey()),
            content: Utils::classFromStruct($docMessage->getContent()),
        );
    }

    /**
     * @throws Exception
     */
    public static function docRefFromWire(Documents $docsClient, Key $keyMessage): DocumentRef
    {
        return new DocumentRef(
            documents: $docsClient,
            collection: self::collectionRefFromWire($docsClient, $keyMessage->getCollection()),
            id: $keyMessage->getId(),
        );
    }

    /**
     * @throws Exception
     */
    public static function collectionRefFromWire(Documents $docsClient, Collection $collectionMessage): CollectionRef
    {
        $parent = null;
        if ($collectionMessage->getParent()) {
            $parent = self::docRefFromWire($docsClient, $collectionMessage->getParent());
        }
        return new CollectionRef(documents: $docsClient, name: $collectionMessage->getName(), parent: $parent);
    }
}
