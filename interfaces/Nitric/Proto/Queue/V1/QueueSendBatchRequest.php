<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: queue/v1/queue.proto

namespace Nitric\Proto\Queue\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>nitric.queue.v1.QueueSendBatchRequest</code>
 */
class QueueSendBatchRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * The Nitric name for the queue
     * this will automatically be resolved to the provider specific queue identifier.
     *
     * Generated from protobuf field <code>string queue = 1;</code>
     */
    protected $queue = '';
    /**
     * Array of tasks to push to the queue
     *
     * Generated from protobuf field <code>repeated .nitric.queue.v1.NitricTask tasks = 2;</code>
     */
    private $tasks;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $queue
     *           The Nitric name for the queue
     *           this will automatically be resolved to the provider specific queue identifier.
     *     @type \Nitric\Proto\Queue\V1\NitricTask[]|\Google\Protobuf\Internal\RepeatedField $tasks
     *           Array of tasks to push to the queue
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
     * Array of tasks to push to the queue
     *
     * Generated from protobuf field <code>repeated .nitric.queue.v1.NitricTask tasks = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Array of tasks to push to the queue
     *
     * Generated from protobuf field <code>repeated .nitric.queue.v1.NitricTask tasks = 2;</code>
     * @param \Nitric\Proto\Queue\V1\NitricTask[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTasks($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Nitric\Proto\Queue\V1\NitricTask::class);
        $this->tasks = $arr;

        return $this;
    }

}

