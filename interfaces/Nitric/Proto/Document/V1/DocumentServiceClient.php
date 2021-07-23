<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Nitric\Proto\Document\V1;

/**
 * Service for storage and retrieval of simple JSON keyValue
 */
class DocumentServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Get an existing document
     * @param \Nitric\Proto\Document\V1\DocumentGetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Get(\Nitric\Proto\Document\V1\DocumentGetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.document.v1.DocumentService/Get',
        $argument,
        ['\Nitric\Proto\Document\V1\DocumentGetResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new or overwrite an existing document
     * @param \Nitric\Proto\Document\V1\DocumentSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Set(\Nitric\Proto\Document\V1\DocumentSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.document.v1.DocumentService/Set',
        $argument,
        ['\Nitric\Proto\Document\V1\DocumentSetResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete an existing document
     * @param \Nitric\Proto\Document\V1\DocumentDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Delete(\Nitric\Proto\Document\V1\DocumentDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.document.v1.DocumentService/Delete',
        $argument,
        ['\Nitric\Proto\Document\V1\DocumentDeleteResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Query the document collection (supports pagination)
     * @param \Nitric\Proto\Document\V1\DocumentQueryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Query(\Nitric\Proto\Document\V1\DocumentQueryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.document.v1.DocumentService/Query',
        $argument,
        ['\Nitric\Proto\Document\V1\DocumentQueryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Query the document collection (supports streaming)
     * @param \Nitric\Proto\Document\V1\DocumentQueryStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function QueryStream(\Nitric\Proto\Document\V1\DocumentQueryStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/nitric.document.v1.DocumentService/QueryStream',
        $argument,
        ['\Nitric\Proto\Document\V1\DocumentQueryStreamResponse', 'decode'],
        $metadata, $options);
    }

}
