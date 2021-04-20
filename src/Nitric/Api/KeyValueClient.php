<?php

namespace Nitric\Api;

use Exception;
use Nitric\Proto\KeyValue\V1\KeyValueClient as GrpcClient;
use Nitric\Proto\KeyValue\V1\KeyValueGetRequest;
use Nitric\Proto\KeyValue\V1\KeyValuePutRequest;
use Nitric\Proto\KeyValue\V1\KeyValueDeleteRequest;
use Nitric\Proto\KeyValue\V1\KeyValueGetResponse;
use stdClass;

class KeyValueClient extends AbstractClient
{
    private GrpcClient $client;

    /**
     * KeyValueClient constructor.
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
     * Store a value by a unique key in the specified collection.
     *
     * @param  string   $collection to store the value in
     * @param  string   $key        unique identifier for this value
     * @param  stdClass $value      the object to store
     * @throws Exception
     */
    public function put(string $collection, string $key, stdClass $value)
    {
        $valueStruct = AbstractClient::structFromClass($value);

        $request = new KeyValuePutRequest();
        $request->setCollection($collection);
        $request->setKey($key);
        $request->setValue($valueStruct);

        [, $status] = $this->client->Put($request)->wait();

        $this->okOrThrow($status);
    }

    /**
     * Retrieve a value from the specified collection by its key.
     *
     * @param  string $collection the value is stored in.
     * @param  string $key        unique identifier of the value to retrieve.
     * @return stdClass the value decoded into an object.
     * @throws Exception
     */
    public function get(string $collection, string $key): stdClass
    {
        $request = new KeyValueGetRequest();
        $request->setCollection($collection);
        $request->setKey($key);

        [$response, $status] = $this->client->Get($request)->wait();
        //        Add type hint to the response object
        $response = (fn($r): KeyValueGetResponse|null => $r)($response);

        $this->okOrThrow($status);
        return json_decode($response->getValue()->serializeToJsonString());
    }

    /**
     * Delete the specified value from the collection.
     *
     * @param  string $collection where the value is stored
     * @param  string $key        of the value to delete
     * @throws Exception
     */
    public function delete(string $collection, string $key)
    {
        $request = new KeyValueDeleteRequest();
        $request->setCollection($collection);
        $request->setKey($key);

        [, $status] = $this->client->Delete($request)->wait();

        $this->okOrThrow($status);
    }
}
