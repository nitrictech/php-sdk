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

use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\HttpServer;
use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Loop;
use Amp\Socket\Server;
use Closure;

/**
 * Function-as-a-Service (Faas) class provides method that assist in writing Serverless Functions, using PHP.
 * @package Nitric\Faas
 */
class Faas
{
    /**
     * Bind address for the FaaS service, defaults to "127.0.0.1:8080".
     * Can be modified via CHILD_ADDRESS environment variable.
     */
    private const CHILD_ADDRESS = "CHILD_ADDRESS";

    /**
     * Begin handling FaaS triggers such as HTTP requests and Events.
     * Each trigger will be passed to the provided handler function, which accepts a Request and returns a Response.
     * @see \Nitric\Faas\Request
     * @see \Nitric\Faas\Response
     * @param $handler Closure function that handles incoming requests
     */
    public static function start(Closure $handler)
    {
        $address = getenv(self::CHILD_ADDRESS) ?: "127.0.0.1:8080";

        Loop::run(
            function () use ($handler, $address) {
                $sockets = [
                Server::listen($address),
                ];

                $server = new HttpServer(
                    $sockets,
                    new CallableRequestHandler(
                        function (Request $request) use ($handler) {
                            $body = yield $request->getBody()->buffer();

                            // Convert HTTP Request to Nitric Request
                            $nitricRequest = \Nitric\Faas\Request::fromHTTPRequest(
                                $request->getHeaders(),
                                $body,
                                $request->getUri()->getPath()
                            );

                            // Call the handler function
                            $nitricResponse = $handler($nitricRequest);

                            // Return the Nitric Response as an HTTP Response
                            return self::httpResponse($nitricResponse);
                        }
                    ),
                    new Logger()
                );

                yield $server->start();

                // Stop the server gracefully when SIGINT is received.
                // This is technically optional, but it is best to call Server::stop().
                Loop::onSignal(
                    SIGINT,
                    function (string $watcherId) use ($server) {
                        Loop::cancel($watcherId);
                        yield $server->stop();
                    }
                );
            }
        );
    }

    /**
     * Convert a NitricResponse to a HTTP response. Used when the FaaS service is operating as an HTTP server.
     * @param \Nitric\Faas\Response $response to be converted
     * @return Response HTTP response representing the input response
     */
    private static function httpResponse(\Nitric\Faas\Response $response): Response
    {
        return new Response(
            $response->getStatus(),
            $response->getHeaders(),
            $response->getBody()
        );
    }
}
