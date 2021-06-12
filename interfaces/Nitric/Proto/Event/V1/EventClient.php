<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Nitric\Proto\Event\V1;

/**
 * Service for publishing asynchronous event
 */
class EventClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Publishes an message to a given topic
     * @param \Nitric\Proto\Event\V1\EventPublishRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Publish(\Nitric\Proto\Event\V1\EventPublishRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.event.v1.Event/Publish',
        $argument,
        ['\Nitric\Proto\Event\V1\EventPublishResponse', 'decode'],
        $metadata, $options);
    }

}
