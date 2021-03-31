<?php

namespace Nitric\Api;

use stdClass;

class Task
{
    private string $id;
    private array|stdClass|null $payload;
    private string $payloadType;
    private string|null $leaseID;

    public function __construct(array|stdClass $payload = null, string $payloadType = "", string $id = "", string $leaseId = null)
    {
        $this->id = $id;
        $this->payload = $payload ?: new stdClass();
        $this->payloadType = $payloadType;
        $this->leaseId = $leaseId;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
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

    /**
     * @return string
     */
    public function getLeaseId(): string
    {
        return $this->leaseId;
    }

    /**
     * @param string $leaseID
     */
    public function setLeaseId(string $leaseID): void
    {
        $this->leaseID = $leaseID;
    }
}