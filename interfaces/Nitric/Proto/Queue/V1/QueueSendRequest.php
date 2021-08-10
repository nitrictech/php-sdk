<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: queue/v1/queue.proto

namespace Nitric\Proto\Queue\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request to push a single event to a queue
 *
 * Generated from protobuf message <code>nitric.queue.v1.QueueSendRequest</code>
 */
class QueueSendRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * The Nitric name for the queue
     * this will automatically be resolved to the provider specific queue identifier.
     *
     * Generated from protobuf field <code>string queue = 1;</code>
     */
    protected $queue = '';
    /**
     * The task to push to the queue
     *
     * Generated from protobuf field <code>.nitric.queue.v1.NitricTask task = 2;</code>
     */
    protected $task = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $queue
     *           The Nitric name for the queue
     *           this will automatically be resolved to the provider specific queue identifier.
     *     @type \Nitric\Proto\Queue\V1\NitricTask $task
     *           The task to push to the queue
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Queue\V1\Queue::initOnce();
        parent::__construct($data);
    }

    /**
     * The Nitric name for the queue
     * this will automatically be resolved to the provider specific queue identifier.
     *
     * Generated from protobuf field <code>string queue = 1;</code>
     * @return string
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * The Nitric name for the queue
     * this will automatically be resolved to the provider specific queue identifier.
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
     * The task to push to the queue
     *
     * Generated from protobuf field <code>.nitric.queue.v1.NitricTask task = 2;</code>
     * @return \Nitric\Proto\Queue\V1\NitricTask|null
     */
    public function getTask()
    {
        return $this->task;
    }

    public function hasTask()
    {
        return isset($this->task);
    }

    public function clearTask()
    {
        unset($this->task);
    }

    /**
     * The task to push to the queue
     *
     * Generated from protobuf field <code>.nitric.queue.v1.NitricTask task = 2;</code>
     * @param \Nitric\Proto\Queue\V1\NitricTask $var
     * @return $this
     */
    public function setTask($var)
    {
        GPBUtil::checkMessage($var, \Nitric\Proto\Queue\V1\NitricTask::class);
        $this->task = $var;

        return $this;
    }

}

