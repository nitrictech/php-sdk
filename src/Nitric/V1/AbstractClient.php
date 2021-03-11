<?php


namespace Nitric\V1;

use Exception;
use Google\Protobuf\Struct;
use Grpc\ChannelCredentials;
use Nitric\V1\Exception\AbortedException;
use Nitric\V1\Exception\AlreadyExistsException;
use Nitric\V1\Exception\CancelledException;
use Nitric\V1\Exception\DataLossException;
use Nitric\V1\Exception\DeadlineExceededException;
use Nitric\V1\Exception\FailedPreconditionException;
use Nitric\V1\Exception\InternalException;
use Nitric\V1\Exception\InvalidArgumentException;
use Nitric\V1\Exception\NotFoundException;
use Nitric\V1\Exception\OutOfRangeException;
use Nitric\V1\Exception\PermissionDeniedException;
use Nitric\V1\Exception\ResourceExhaustedException;
use Nitric\V1\Exception\UnauthenticatedException;
use Nitric\V1\Exception\UnavailableException;
use Nitric\V1\Exception\UnimplementedException;
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
 * Class AbstractClient
 *
 * Provides common client class functionality and configuration.
 *
 * @package Nitric\V1
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