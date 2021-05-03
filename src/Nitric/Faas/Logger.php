<?php

/**
 * Copyright 2021-2021 Nitric Pty Ltd.
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

use Psr\Log\AbstractLogger;

/**
 * Class Logger provides a basic logger implementation, enabling the FaaS HTTP server to print to stdout.
 * @package Nitric\Faas
 */
class Logger extends AbstractLogger
{
    /**
     * Combine a message and its context into a static string.
     * @param string $message template string
     * @param array $context message context, containing variables to be merged into $message
     * @return string the resulting message string, with context merged
     */
    public static function interpolate($message, $context): string
    {
        $contextTokens = array();
        foreach ($context as $k => $v) {
            $contextTokens["{" . $k . "}"] = print_r($v, true);
        }
        return strtr($message, $contextTokens);
    }

    /**
     * Log output to stdout (printf) in the format: `{level}: {message}\n{exception}`.
     * @param mixed $level log level
     * @param string $message to be merged with $context before output
     * @param array $context to be merged into $message before output
     */
    public function log($level, $message, array $context = array())
    {
        $mergedMessage = self::interpolate($message, $context);
        $exception = isset($context['exception']) ?  $context['exception'] . "\n" : "";
        printf("%s: %s\n%s", $level, $mergedMessage, $exception);
    }
}
