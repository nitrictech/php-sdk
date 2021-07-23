<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Nitric\Proto\Queue\V1;

/**
 * The Nitric Queue Service contract
 */
class QueueServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Send a single event to a queue
     * @param \Nitric\Proto\Queue\V1\QueueSendRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Send(\Nitric\Proto\Queue\V1\QueueSendRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.queue.v1.QueueService/Send',
        $argument,
        ['\Nitric\Proto\Queue\V1\QueueSendResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Send multiple events to a queue
     * @param \Nitric\Proto\Queue\V1\QueueSendBatchRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SendBatch(\Nitric\Proto\Queue\V1\QueueSendBatchRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.queue.v1.QueueService/SendBatch',
        $argument,
        ['\Nitric\Proto\Queue\V1\QueueSendBatchResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Receive event(s) off a queue
     * @param \Nitric\Proto\Queue\V1\QueueReceiveRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Receive(\Nitric\Proto\Queue\V1\QueueReceiveRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.queue.v1.QueueService/Receive',
        $argument,
        ['\Nitric\Proto\Queue\V1\QueueReceiveResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Complete an event previously popped from a queue
     * @param \Nitric\Proto\Queue\V1\QueueCompleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Complete(\Nitric\Proto\Queue\V1\QueueCompleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.queue.v1.QueueService/Complete',
        $argument,
        ['\Nitric\Proto\Queue\V1\QueueCompleteResponse', 'decode'],
        $metadata, $options);
    }

}
