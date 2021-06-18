<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Nitric\Proto\Faas\V1;

/**
 * Service for streaming communication with gRPC FaaS implementations
 */
class FaasClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Begin streaming triggers/response to/from the membrane
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\BidiStreamingCall
     */
    public function TriggerStream($metadata = [], $options = []) {
        return $this->_bidiRequest('/nitric.faas.v1.Faas/TriggerStream',
        ['\Nitric\Proto\Faas\V1\ServerMessage','decode'],
        $metadata, $options);
    }

}
