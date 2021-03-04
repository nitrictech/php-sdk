<?php


namespace Nitric\V1;

use Exception;
use Grpc\ChannelCredentials;
use const Grpc\STATUS_OK;

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

    protected function checkStatus($status)
    {
        // TODO: Handle other status codes
        if ($status->code != STATUS_OK) {
            throw new Exception($status->details);
        }
    }
}