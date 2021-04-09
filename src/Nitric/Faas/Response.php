<?php


namespace Nitric\Faas;


class Response
{
    private string $body;
    private int $status;
    private array $headers;

    /**
     * @return string
     */
    public function getBody(): string
    {
        if ($this->body == null) {
            return "";
        }
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * Response constructor.
     * @param string $body
     * @param int $status
     * @param array $headers
     */
    public function __construct(string $body = "", int $status = 200, array $headers = [])
    {
        $this->body = $body;
        $this->status = $status;
        $this->headers = $headers;
    }
}