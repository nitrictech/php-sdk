<?php


namespace Nitric\V1\Faas;


class Request
{
    private Context $context;
    private string $payload;
    private string $path;

    /**
     * Request constructor.
     * @param Context $context
     * @param string $payload
     * @param string $path
     */
    public function __construct(Context $context, string $payload, string $path)
    {
        $this->context = $context;
        $this->payload = $payload;
        $this->path = $path;
    }


    static function fromHTTPRequest(array $headers, string $payload, string $path): Request
    {
        $context = Context::fromHeaders($headers);

        return new Request(
            context:  $context,
            payload: $payload,
            path: $path
        );


    }

    /**
     * @return Context
     */
    public function getContext(): Context
    {
        return $this->context;
    }

    /**
     * @param Context $context
     */
    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload(string $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }
}