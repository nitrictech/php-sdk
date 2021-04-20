<?php

namespace Nitric\Faas;

use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\HttpServer;
use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Loop;
use Amp\Socket\Server;

class Faas
{
    private const CHILD_ADDRESS = "CHILD_ADDRESS";

    public static function start($handler)
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

    public static function httpResponse(\Nitric\Faas\Response $response): Response
    {
        return new Response(
            $response->getStatus(),
            $response->getHeaders(),
            $response->getBody()
        );
    }
}
