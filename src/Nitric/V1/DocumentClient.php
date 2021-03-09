<?php


namespace Nitric\V1;

use Exception;
use \Nitric\BaseClient\V1\Documents\DocumentClient as GrpcClient;
use Nitric\BaseClient\V1\Documents\DocumentCreateRequest;
use Nitric\BaseClient\V1\Documents\DocumentDeleteRequest;
use Nitric\BaseClient\V1\Documents\DocumentGetRequest;
use Nitric\BaseClient\V1\Documents\DocumentGetResponse;
use Nitric\BaseClient\V1\Documents\DocumentUpdateRequest;
use stdClass;

class DocumentClient extends AbstractClient
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
     * Create a new document with the specified key in the specified collection.
     *
     * @param string $collection to store the document in
     * @param string $key unique identifier for this document
     * @param stdClass $document the document to store
     * @throws Exception
     */
    public function create(string $collection, string $key, stdClass $document)
    {
        $docStruct = Utils::structFromClass($document);

        $request = new DocumentCreateRequest();
        $request->setCollection($collection);
        $request->setKey($key);
        $request->setDocument($docStruct);

        [, $status] = $this->client->Create($request)->wait();

        $this->checkStatus($status);
    }

    /**
     * Retrieve a document from the specified collection by its key.
     *
     * @param string $collection the document is stored in.
     * @param string $key unique identifier of the document to retrieve.
     * @return stdClass the document decoded into an object.
     * @throws Exception
     */
    public function get(string $collection, string $key): stdClass
    {
        $request = new DocumentGetRequest();
        $request->setCollection($collection);
        $request->setKey($key);

        [$response, $status] = $this->client->Get($request)->wait();
//        Add type hint to the response object
        $response = (fn($r): DocumentGetResponse|null => $r)($response);

        $this->checkStatus($status);
        return json_decode($response->getDocument()->serializeToJsonString());
    }

    /**
     * Update the contents of an existing document.
     *
     * @param string $collection to store the document in
     * @param string $key unique identifier for the document
     * @param stdClass $document the new document to store
     * @throws Exception
     */
    public function update(string $collection, string $key, stdClass $document)
    {
        $docStruct = Utils::structFromClass($document);

        $request = new DocumentUpdateRequest();
        $request->setCollection($collection);
        $request->setKey($key);
        $request->setDocument($docStruct);

        [, $status] = $this->client->Update($request)->wait();

        $this->checkStatus($status);
    }

    /**
     * Delete the specified document from the collection.
     * @param string $collection where the document is stored
     * @param string $key of the document to delete
     * @throws Exception
     */
    public function delete(string $collection, string $key)
    {
        $request = new DocumentDeleteRequest();
        $request->setCollection($collection);
        $request->setKey($key);

        [, $status] = $this->client->Delete($request)->wait();

        $this->checkStatus($status);
    }
}