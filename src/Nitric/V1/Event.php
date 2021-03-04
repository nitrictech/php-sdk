<?php


namespace Nitric\V1;


use stdClass;

class Event
{
    private string $requestID;
    private array|stdClass|null $payload;
    private string $payloadType;

    public function __construct(array|stdClass $payload = null, string $payloadType = "", string $requestID = "")
    {
        $this->payload = $payload;
        $this->payloadType = $payloadType;
        $this->requestID = $requestID;
    }

    /**
     * @return string
     */
    public function getRequestID(): string
    {
        return $this->requestID;
    }

    /**
     * @param string $requestID
     */
    public function setRequestID(string $requestID): void
    {
        $this->requestID = $requestID;
    }

    /**
     * @return array|stdClass
     */
    public function getPayload(): array|stdClass
    {
        return $this->payload;
    }

    /**
     * @param array|stdClass $payload
     */
    public function setPayload(array|stdClass $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getPayloadType(): string
    {
        return $this->payloadType;
    }

    /**
     * @param string $payloadType
     */
    public function setPayloadType(string $payloadType): void
    {
        $this->payloadType = $payloadType;
    }
}