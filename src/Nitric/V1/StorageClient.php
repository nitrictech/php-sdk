<?php


namespace Nitric\V1;


use Exception;
use Nitric\BaseClient\V1\Storage\StorageClient as GrpcClient;
use Nitric\BaseClient\V1\Storage\StorageGetRequest;
use Nitric\BaseClient\V1\Storage\StorageGetResponse;
use Nitric\BaseClient\V1\Storage\StoragePutRequest;

class StorageClient extends AbstractClient
{
    private GrpcClient $client;

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
     * @param string $bucketName Nitric name of the bucket to store the file in.
     * @param string $key within the bucket where the file should be stored.
     * @param string $bytes byte string containing the file contents to store.
     * @throws Exception
     */
    public function put(string $bucketName, string $key, string $bytes)
    {
        $request = new StoragePutRequest();
        $request->setBucketName($bucketName);
        $request->setKey($key);
        $request->setBody($bytes);

        [, $status] = $this->client->Put($request)->wait();
        $this->okOrThrow($status);
    }

    /**
     * @param string $bucketName Nitric name of the bucket where the file is stored.
     * @param string $key for the file to retrieve
     * @return string body data as a byte string.
     * @throws Exception
     */
    public function get(string $bucketName, string $key): string
    {
        $request = new StorageGetRequest();
        $request->setBucketName($bucketName);
        $request->setKey($key);

        [$response, $status] = $this->client->Get($request)->wait();
        $this->okOrThrow($status);
        $response = (fn($r): StorageGetResponse => $r)($response);

        return $response->getBody();
    }
}