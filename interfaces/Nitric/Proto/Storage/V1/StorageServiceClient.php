<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Nitric\Proto\Storage\V1;

/**
 * Services for storage and retrieval of files in the form of byte arrays, such as text and binary files.
 */
class StorageServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Retrieve an item from a bucket
     * @param \Nitric\Proto\Storage\V1\StorageReadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Read(\Nitric\Proto\Storage\V1\StorageReadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.storage.v1.StorageService/Read',
        $argument,
        ['\Nitric\Proto\Storage\V1\StorageReadResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Store an item to a bucket
     * @param \Nitric\Proto\Storage\V1\StorageWriteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Write(\Nitric\Proto\Storage\V1\StorageWriteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.storage.v1.StorageService/Write',
        $argument,
        ['\Nitric\Proto\Storage\V1\StorageWriteResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete an item from a bucket
     * @param \Nitric\Proto\Storage\V1\StorageDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Delete(\Nitric\Proto\Storage\V1\StorageDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.storage.v1.StorageService/Delete',
        $argument,
        ['\Nitric\Proto\Storage\V1\StorageDeleteResponse', 'decode'],
        $metadata, $options);
    }

}
