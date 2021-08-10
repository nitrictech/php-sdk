<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Nitric\Proto\Secret\V1;

/**
 * The Nitric Secret Service contract
 */
class SecretServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Updates a secret, creating a new one if it doesn't already exist
     * @param \Nitric\Proto\Secret\V1\SecretPutRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Put(\Nitric\Proto\Secret\V1\SecretPutRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.secret.v1.SecretService/Put',
        $argument,
        ['\Nitric\Proto\Secret\V1\SecretPutResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a secret from a Secret Store
     * @param \Nitric\Proto\Secret\V1\SecretAccessRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Access(\Nitric\Proto\Secret\V1\SecretAccessRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.secret.v1.SecretService/Access',
        $argument,
        ['\Nitric\Proto\Secret\V1\SecretAccessResponse', 'decode'],
        $metadata, $options);
    }

}
