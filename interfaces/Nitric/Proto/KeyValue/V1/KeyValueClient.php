<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Nitric\Proto\KeyValue\V1;

/**
 * Service for storage and retrieval of simple JSON keyValue
 */
class KeyValueClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Get an existing key
     * @param \Nitric\Proto\KeyValue\V1\KeyValueGetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Get(\Nitric\Proto\KeyValue\V1\KeyValueGetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.kv.v1.KeyValue/Get',
        $argument,
        ['\Nitric\Proto\KeyValue\V1\KeyValueGetResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new or overwrite and existing key
     * @param \Nitric\Proto\KeyValue\V1\KeyValuePutRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Put(\Nitric\Proto\KeyValue\V1\KeyValuePutRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.kv.v1.KeyValue/Put',
        $argument,
        ['\Nitric\Proto\KeyValue\V1\KeyValuePutResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete an existing
     * @param \Nitric\Proto\KeyValue\V1\KeyValueDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Delete(\Nitric\Proto\KeyValue\V1\KeyValueDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.kv.v1.KeyValue/Delete',
        $argument,
        ['\Nitric\Proto\KeyValue\V1\KeyValueDeleteResponse', 'decode'],
        $metadata, $options);
    }

}
