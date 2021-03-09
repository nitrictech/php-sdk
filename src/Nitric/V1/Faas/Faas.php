<?php


namespace Nitric\V1\Faas;

use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\HttpServer;
use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Http\Status;
use Amp\Loop;
use Amp\Socket\Server;
use Psr\Log\NullLogger;

class Faas
{
    private const CHILD_ADDRESS = "CHILD_ADDRESS";

    static function start($handler)
    {
        $address = getenv(self::CHILD_ADDRESS) ?: "127.0.0.1:8080";

        Loop::run(function () use ($handler, $address) {
            $sockets = [
                Server::listen($address),
            ];

            $server = new HttpServer($sockets, new CallableRequestHandler(function (Request $request) use ($handler) {
                $body = yield $request->getBody()->buffer();

                // Convert HTTP Request to Nitric Request
                $nitricRequest = \Nitric\V1\Faas\Request::fromHTTPRequest(
                    $request->getHeaders(),
                    $body,
                    $request->getUri()->getPath()
                );

                // Call the handler function
                try {
                    $nitricResponse = $handler($nitricRequest);
                    return self::httpResponse($nitricResponse);
                } catch (\RuntimeException $e) {
                    return new Response(Status::OK, [
                    "content-type" => "text/plain; charset=utf-8"
                ], $e->getMessage());
                }

                // Convert the Nitric Response to HTTP Response


//                 Return the response
//                return new Response(Status::OK, [
//                    "content-type" => "text/plain; charset=utf-8"
//                ], "testing");
            }), new Logger());

            yield $server->start();

            // Stop the server gracefully when SIGINT is received.
            // This is technically optional, but it is best to call Server::stop().
            Loop::onSignal(SIGINT, function (string $watcherId) use ($server) {
                Loop::cancel($watcherId);
                yield $server->stop();
            });
        });
    }

    static function httpResponse(\Nitric\V1\Faas\Response $response): Response
    {
       return new Response(
            $response->getStatus(),
            $response->getHeaders(),
            $response->getBody()
        );
    }
}