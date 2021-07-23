<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Nitric\Proto\Event\V1;

/**
 * Service for management of event topics
 */
class TopicServiceClient extends \Grpc\BaseStub {

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
     * @param \Nitric\Proto\Event\V1\TopicListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function List(\Nitric\Proto\Event\V1\TopicListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.event.v1.TopicService/List',
        $argument,
        ['\Nitric\Proto\Event\V1\TopicListResponse', 'decode'],
        $metadata, $options);
    }

}
