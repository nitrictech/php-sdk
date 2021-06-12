<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: queue/v1/queue.proto

namespace Nitric\Proto\Queue\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>nitric.queue.v1.QueueCompleteRequest</code>
 */
class QueueCompleteRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * The nitric name for the queue
     *  this will automatically be resolved to the provider specific queue identifier.
     *
     * Generated from protobuf field <code>string queue = 1;</code>
     */
    protected $queue = '';
    /**
     * Lease id of the task to be completed
     *
     * Generated from protobuf field <code>string leaseId = 2;</code>
     */
    protected $leaseId = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $queue
     *           The nitric name for the queue
     *            this will automatically be resolved to the provider specific queue identifier.
     *     @type string $leaseId
     *           Lease id of the task to be completed
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Queue\V1\Queue::initOnce();
        parent::__construct($data);
    }

    /**
     * The nitric name for the queue
     *  this will automatically be resolved to the provider specific queue identifier.
     *
     * Generated from protobuf field <code>string queue = 1;</code>
     * @return string
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * The nitric name for the queue
     *  this will automatically be resolved to the provider specific queue identifier.
     *
     * Generated from protobuf field <code>string queue = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setQueue($var)
    {
        GPBUtil::checkString($var, True);
        $this->queue = $var;

        return $this;
    }

    /**
     * Lease id of the task to be completed
     *
     * Generated from protobuf field <code>string leaseId = 2;</code>
     * @return string
     */
    public function getLeaseId()
    {
        return $this->leaseId;
    }

    /**
     * Lease id of the task to be completed
     *
     * Generated from protobuf field <code>string leaseId = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setLeaseId($var)
    {
        GPBUtil::checkString($var, True);
        $this->leaseId = $var;

        return $this;
    }

}

