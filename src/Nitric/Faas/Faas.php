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

use Amp\ByteStream\IteratorStream;
use Amp\Http\Server\Driver\Client;
use Grpc\ChannelCredentials;
use Amp\Loop;
use Amp\Parallel\Worker;
use Amp\Producer;
use Nitric\Proto\Faas\V1\FaasClient;
use Nitric\Proto\Faas\V1\InitRequest;
use Nitric\Proto\Faas\V1\ServerMessage;
use Nitric\Proto\Faas\V1\ClientMessage;
use Closure;

use function Amp\call;

/**
 * Function-as-a-Service (Faas) class provides method that assist in writing Serverless Functions, using PHP.
 * @package Nitric\Faas
 */
class Faas
{
    private const SERVICE_ADDRESS = "SERVICE_ADDRESS";

    /**
     * Begin handling FaaS triggers such as HTTP requests and Events.
     * Each trigger will be passed to the provided handler function, which accepts a Request and returns a Response.
     * @see \Nitric\Faas\Request
     * @see \Nitric\Faas\Response
     * @param $handler Closure function that handles incoming requests
     */
    public static function start(Closure $handler)
    {
        $address = getenv(self::SERVICE_ADDRESS) ?: "127.0.0.1:50051";

        $opts = [
            'credentials' => ChannelCredentials::createInsecure(),
        ];

        // TODO: Set credentials here...
        $faasClient = new FaasClient($address, $opts);
        $call = $faasClient->TriggerStream();
        $init = new InitRequest();
        // Write the InitRequest to connect
        $msg = new ClientMessage();
        $msg->setInitRequest($init);
        $call->write($msg);

        Loop::run(
            function () use ($call, $handler) {
                Loop::onSignal(
                    SIGINT,
                    function (string $watcherId) use ($call) {
                        Loop::cancel($watcherId);
                        // Cancel the gRPC stream
                        $call->writesDone();
                    }
                );

                while (1) {
                    // print("\nstarting read!\n");
                    $readResult = yield call(array($call, 'read'));
                    // print("\nGot request:\n");
                    //print($readResult->serializeToJsonString());

                    if ($readResult == null) {
                        break;
                    }

                    if ($readResult instanceof ServerMessage) {
                        if ($readResult->hasInitResponse()) {
                            // We're one with the membrane
                            // continue the loop and do nothing
                            print("Function connected to membrane");
                        } elseif ($readResult->hasTriggerRequest()) {
                            // handle the trigger request
                            $triggerRequest = $readResult->getTriggerRequest();
                            $request = Request::fromTriggerRequest($triggerRequest);

                            // Handle the userspace function
                            $result = yield call($handler, $request);

                            $triggerResponse = null;

                            if ($result instanceof Response) {
                                // Assume its a string
                                $triggerResponse = $result->toTriggerResponse();
                            } else {
                                // Assume its a string
                                $dataResult = (string) $result;

                                $defaultResponse = $request->getDefaultResponse();
                                $defaultResponse->setData($dataResult);

                                $triggerResponse = $defaultResponse->toTriggerResponse();
                            }

                            $returnMsg = new ClientMessage();
                            $returnMsg->setId($readResult->getId());
                            $returnMsg->setTriggerResponse($triggerResponse);

                            yield call(array($call, 'write'), $returnMsg);
                            //yield $emit(".");
                        } else {
                            // Invalid message recieved
                        }
                    }
                }
            }
        );

        //print("Exited loop :( \n");
    }
}
