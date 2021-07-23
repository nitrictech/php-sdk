<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: queue/v1/queue.proto

namespace Nitric\Proto\Queue\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A task to be sent or received from a queue.
 *
 * Generated from protobuf message <code>nitric.queue.v1.NitricTask</code>
 */
class NitricTask extends \Google\Protobuf\Internal\Message
{
    /**
     * A unique id for the task
     *
     * Generated from protobuf field <code>string id = 1;</code>
     */
    protected $id = '';
    /**
     * The lease id unique to the pop request, this must be used to complete, extend the lease or release the task.
     *
     * Generated from protobuf field <code>string lease_id = 2;</code>
     */
    protected $lease_id = '';
    /**
     * A content hint for the tasks payload
     *
     * Generated from protobuf field <code>string payload_type = 3;</code>
     */
    protected $payload_type = '';
    /**
     * The payload of the task
     *
     * Generated from protobuf field <code>.google.protobuf.Struct payload = 4;</code>
     */
    protected $payload = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $id
     *           A unique id for the task
     *     @type string $lease_id
     *           The lease id unique to the pop request, this must be used to complete, extend the lease or release the task.
     *     @type string $payload_type
     *           A content hint for the tasks payload
     *     @type \Google\Protobuf\Struct $payload
     *           The payload of the task
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Queue\V1\Queue::initOnce();
        parent::__construct($data);
    }

    /**
     * A unique id for the task
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * A unique id for the task
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

    /**
     * The lease id unique to the pop request, this must be used to complete, extend the lease or release the task.
     *
     * Generated from protobuf field <code>string lease_id = 2;</code>
     * @return string
     */
    public function getLeaseId()
    {
        return $this->lease_id;
    }

    /**
     * The lease id unique to the pop request, this must be used to complete, extend the lease or release the task.
     *
     * Generated from protobuf field <code>string lease_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setLeaseId($var)
    {
        GPBUtil::checkString($var, True);
        $this->lease_id = $var;

        return $this;
    }

    /**
     * A content hint for the tasks payload
     *
     * Generated from protobuf field <code>string payload_type = 3;</code>
     * @return string
     */
    public function getPayloadType()
    {
        return $this->payload_type;
    }

    /**
     * A content hint for the tasks payload
     *
     * Generated from protobuf field <code>string payload_type = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setPayloadType($var)
    {
        GPBUtil::checkString($var, True);
        $this->payload_type = $var;

        return $this;
    }

    /**
     * The payload of the task
     *
     * Generated from protobuf field <code>.google.protobuf.Struct payload = 4;</code>
     * @return \Google\Protobuf\Struct
     */
    public function getPayload()
    {
        return isset($this->payload) ? $this->payload : null;
    }

    public function hasPayload()
    {
        return isset($this->payload);
    }

    public function clearPayload()
    {
        unset($this->payload);
    }

    /**
     * The payload of the task
     *
     * Generated from protobuf field <code>.google.protobuf.Struct payload = 4;</code>
     * @param \Google\Protobuf\Struct $var
     * @return $this
     */
    public function setPayload($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Struct::class);
        $this->payload = $var;

        return $this;
    }

}

