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

namespace Nitric\Api;

use Exception;
use Google\Protobuf\Struct;
use Grpc\ChannelCredentials;
use Nitric\Api\Exception\AbortedException;
use Nitric\Api\Exception\AlreadyExistsException;
use Nitric\Api\Exception\CancelledException;
use Nitric\Api\Exception\DataLossException;
use Nitric\Api\Exception\DeadlineExceededException;
use Nitric\Api\Exception\FailedPreconditionException;
use Nitric\Api\Exception\InternalException;
use Nitric\Api\Exception\InvalidArgumentException;
use Nitric\Api\Exception\NotFoundException;
use Nitric\Api\Exception\OutOfRangeException;
use Nitric\Api\Exception\PermissionDeniedException;
use Nitric\Api\Exception\ResourceExhaustedException;
use Nitric\Api\Exception\UnauthenticatedException;
use Nitric\Api\Exception\UnavailableException;
use Nitric\Api\Exception\UnimplementedException;
use stdClass;

use const Grpc\STATUS_ABORTED;
use const Grpc\STATUS_ALREADY_EXISTS;
use const Grpc\STATUS_CANCELLED;
use const Grpc\STATUS_DATA_LOSS;
use const Grpc\STATUS_DEADLINE_EXCEEDED;
use const Grpc\STATUS_FAILED_PRECONDITION;
use const Grpc\STATUS_INTERNAL;
use const Grpc\STATUS_INVALID_ARGUMENT;
use const Grpc\STATUS_NOT_FOUND;
use const Grpc\STATUS_OK;
use const Grpc\STATUS_OUT_OF_RANGE;
use const Grpc\STATUS_PERMISSION_DENIED;
use const Grpc\STATUS_RESOURCE_EXHAUSTED;
use const Grpc\STATUS_UNAUTHENTICATED;
use const Grpc\STATUS_UNAVAILABLE;
use const Grpc\STATUS_UNIMPLEMENTED;

/**
 * Class AbstractClient, provides common client class functionality and configuration.
 * Only used when implementing a new gRPC client for the Nitric API.
 *
 * @package Nitric\Api
 */
abstract class AbstractClient
{
    private const SERVICE_BIND = "SERVICE_BIND";
    protected string $hostname;
    protected array $opts;

    public function __construct()
    {
        // Retrieve the Nitric service address, defaulting to the standard local ip and port.
        $this->hostname = getenv(self::SERVICE_BIND) ?: "127.0.0.1:50051";
        $this->opts = [
            'credentials' => ChannelCredentials::createInsecure(),
        ];
    }

    public static function structFromClass(stdClass $obj): Struct
    {
        $struct = new Struct();
        try {
            $struct->mergeFromJsonString(json_encode($obj));
        } catch (Exception $e) {
            throw new Exception("Failed to serialize object. Details: " . $e->getMessage());
        }
        return $struct;
    }

    public static function classFromStruct(Struct $struct): stdClass|null
    {
        if ($struct == null) {
            return null;
        }
        try {
            return json_decode($struct->serializeToJsonString());
        } catch (Exception $e) {
            throw new Exception("Failed to deserialize struct. Details: " . $e->getMessage());
        }
    }

    /**
     * Check the status returned from an autogenerate gRPC client call. If any status other than OK is detected, throw
     * the corresponding exception type.
     *
     * @param $status
     */
    protected function okOrThrow($status)
    {
        if ($status->code == STATUS_OK) {
            // No exceptions or details in the of a successful response status.
            return;
        }

        // Set a default error message, details aren't always provided in the status.
        $details = isset($status->details) ? $status->details : "An unexpected error occurred.";

        // Construct and throw the appropriate exception for each status
        throw new (match ($status->code) {
            STATUS_ABORTED => AbortedException::class,
            STATUS_ALREADY_EXISTS => AlreadyExistsException::class,
            STATUS_CANCELLED => CancelledException::class,
            STATUS_DATA_LOSS => DataLossException::class,
            STATUS_DEADLINE_EXCEEDED => DeadlineExceededException::class,
            STATUS_FAILED_PRECONDITION => FailedPreconditionException::class,
            STATUS_INTERNAL => InternalException::class,
            STATUS_INVALID_ARGUMENT => InvalidArgumentException::class,
            STATUS_OUT_OF_RANGE => OutOfRangeException::class,
            STATUS_NOT_FOUND => NotFoundException::class,
            STATUS_PERMISSION_DENIED => PermissionDeniedException::class,
            STATUS_RESOURCE_EXHAUSTED => ResourceExhaustedException::class,
            STATUS_UNAUTHENTICATED => UnauthenticatedException::class,
            STATUS_UNAVAILABLE => UnavailableException::class,
            STATUS_UNIMPLEMENTED => UnimplementedException::class,
            default => Exception::class // Includes STATUS_UNKNOWN
        })($details);
    }
}
