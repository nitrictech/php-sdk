<?php

namespace Nitric\Faas;

class Context
{
    private string|null $requestID;
    private string|null $source;
    private string $sourceType;
    private string|null $payloadType;

    /**
     * Context constructor.
     *
     * @param string|null $requestID
     * @param string|null $source
     * @param string      $sourceType
     * @param string|null $payloadType
     */
    public function __construct(
        string|null $requestID,
        string|null $source,
        string $sourceType,
        string|null $payloadType
    ) {
        $this->requestID = $requestID;
        $this->source = $source;
        $this->sourceType = SourceType::fromString($sourceType);
        $this->payloadType = $payloadType;
    }

    private static function getValueIfExists($array, $key)
    {
        return isset($array[$key]) ? $array[$key][0] : null;
    }

    public static function fromHeaders(array $headers): Context
    {
        $requestId = self::getValueIfExists($headers, "x-nitric-request-id");
        $sourceType = self::getValueIfExists($headers, "x-nitric-source-type") ?: "UNKNOWN";
        $source =  self::getValueIfExists($headers, "x-nitric-source");
        $payloadType = self::getValueIfExists($headers, "x-nitric-payload-type");

        return new Context(
            $requestId,
            $source,
            $sourceType,
            $payloadType
        );
    }

    /**
     * @return string
     */
    public function getRequestID(): string|null
    {
        return $this->requestID;
    }

    /**
     * @param string $requestID
     */
    public function setRequestID(string|null $requestID): void
    {
        $this->requestID = $requestID;
    }

    /**
     * @return string
     */
    public function getSource(): string|null
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string|null $source): void
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getSourceType(): string
    {
        return $this->sourceType;
    }

    /**
     * @param string $sourceType
     */
    public function setSourceType(string $sourceType): void
    {
        $this->sourceType = SourceType::fromString($sourceType);
    }

    /**
     * @return string
     */
    public function getPayloadType(): string|null
    {
        return $this->payloadType;
    }

    /**
     * @param string $payloadType
     */
    public function setPayloadType(string|null $payloadType): void
    {
        $this->payloadType = $payloadType;
    }
}
