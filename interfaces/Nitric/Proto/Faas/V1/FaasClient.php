<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Nitric\Proto\Faas\V1;

/**
 * Service for management of event topics
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
     * Return a list of existing topics in the provider environment
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
