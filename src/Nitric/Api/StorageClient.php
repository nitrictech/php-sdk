<?php

namespace Nitric\Api;

use Exception;
use Nitric\Proto\Storage\V1\StorageClient as GrpcClient;
use Nitric\Proto\Storage\V1\StorageReadRequest;
use Nitric\Proto\Storage\V1\StorageReadResponse;
use Nitric\Proto\Storage\V1\StorageWriteRequest;

class StorageClient extends AbstractClient
{
    private GrpcClient $client;

    /**
     * StorageClient constructor.
     *
     * @param GrpcClient|null $client the autogenerated gRPC client object. Typically only injected for mocked testing.
     */
    public function __construct(GrpcClient $client = null)
    {
        parent::__construct();
        if ($client) {
            $this->client = $client;
        } else {
            $this->client = new GrpcClient($this->hostname, $this->opts);
        }
    }

    /**
     * Store a file
     *
     * @param  string $bucket Nitric name of the bucket to store the file in.
     * @param  string $key    within the bucket where the file should be stored.
     * @param  string $bytes  byte string containing the file contents to store.
     * @throws Exception
     */
    public function write(string $bucket, string $key, string $bytes)
    {
        $request = new StorageWriteRequest();
        $request->setBucketName($bucket);
        $request->setKey($key);
        $request->setBody($bytes);

        [, $status] = $this->client->Write($request)->wait();
        $this->okOrThrow($status);
    }

    /**
     * @param  string $bucket Nitric name of the bucket where the file is stored.
     * @param  string $key    for the file to retrieve
     * @return string body data as a byte string.
     * @throws Exception
     */
    public function read(string $bucket, string $key): string
    {
        $request = new StorageReadRequest();
        $request->setBucketName($bucket);
        $request->setKey($key);

        [$response, $status] = $this->client->Read($request)->wait();
        $this->okOrThrow($status);
        $response = (fn ($r): StorageReadResponse => $r)($response);

        return $response->getBody();
    }
}
