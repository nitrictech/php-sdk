<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: queue/v1/queue.proto

namespace Nitric\Proto\Queue\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>nitric.queue.v1.FailedTask</code>
 */
class FailedTask extends \Google\Protobuf\Internal\Message
{
    /**
     * The task that failed to be pushed
     *
     * Generated from protobuf field <code>.nitric.queue.v1.NitricTask task = 1;</code>
     */
    protected $task = null;
    /**
     * A message describing the failure
     *
     * Generated from protobuf field <code>string message = 2;</code>
     */
    protected $message = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Nitric\Proto\Queue\V1\NitricTask $task
     *           The task that failed to be pushed
     *     @type string $message
     *           A message describing the failure
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Queue\V1\Queue::initOnce();
        parent::__construct($data);
    }

    /**
     * The task that failed to be pushed
     *
     * Generated from protobuf field <code>.nitric.queue.v1.NitricTask task = 1;</code>
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
     * The task that failed to be pushed
     *
     * Generated from protobuf field <code>.nitric.queue.v1.NitricTask task = 1;</code>
     * @param \Nitric\Proto\Queue\V1\NitricTask $var
     * @return $this
     */
    public function setTask($var)
    {
        GPBUtil::checkMessage($var, \Nitric\Proto\Queue\V1\NitricTask::class);
        $this->task = $var;

        return $this;
    }

    /**
     * A message describing the failure
     *
     * Generated from protobuf field <code>string message = 2;</code>
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * A message describing the failure
     *
     * Generated from protobuf field <code>string message = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setMessage($var)
    {
        GPBUtil::checkString($var, True);
        $this->message = $var;

        return $this;
    }

}

