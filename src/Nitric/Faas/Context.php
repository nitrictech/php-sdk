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

namespace Nitric\Faas;

use Nitric\Proto\Faas\V1\HttpTriggerContext;
use Nitric\Proto\Faas\V1\TopicTriggerContext;
use Nitric\Proto\Faas\V1\TriggerRequest;

/**
 * Class Context represents the metadata of a FaaS request
 * @package Nitric\Faas
 */
abstract class Context
{

    /**
     * @return boolean
     */
    public function isTopic()
    {
        return $this instanceof TopicContext;
    }

    /**
     * @return boolean
     */
    public function isHttp()
    {
        return $this instanceof HttpContext;
    }

    /**
     * @return TopicContext
     */
    public function asTopicContext()
    {
        if ($this instanceof TopicContext) {
            return $this;
        }
        // Throw exception
    }

    /**
     * @return HttpContext
     */
    public function asHttpContext()
    {
        if ($this instanceof HttpContext) {
            return $this;
        }

        // Throw exception
    }

    /**
     * @return HttpContext
     */
    public static function fromHttpTriggerContext(HttpTriggerContext $context)
    {
        return new HttpContext(
            $context->getMethod(),
            (array) $context->getHeaders(),
            (array) $context->getQueryParams(),
            (array) $context->getPathParams()
        );
    }

    /**
     * @return TopicContext
     */
    public static function fromTopicTriggerContext(TopicTriggerContext $context)
    {
        return new TopicContext(
            $context->getTopic()
        );
    }

    /**
     * @return Context
     */
    public static function fromTriggerRequest(TriggerRequest $request)
    {
        if ($request->hasHttp()) {
            return Context::fromHttpTriggerContext($request->getHttp());
        } elseif ($request->hasTopic()) {
            return Context::fromTopicTriggerContext($request->getTopic());
        }
    }
}
