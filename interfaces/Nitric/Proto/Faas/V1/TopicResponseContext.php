<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: faas/v1/faas.proto

namespace Nitric\Proto\Faas\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Specific event response message
 * We do not accept responses for events
 * only whether or not they were successfully processed
 *
 * Generated from protobuf message <code>nitric.faas.v1.TopicResponseContext</code>
 */
class TopicResponseContext extends \Google\Protobuf\Internal\Message
{
    /**
     * Success status of the handled event
     *
     * Generated from protobuf field <code>bool success = 1;</code>
     */
    protected $success = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $success
     *           Success status of the handled event
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Faas\V1\Faas::initOnce();
        parent::__construct($data);
    }

    /**
     * Success status of the handled event
     *
     * Generated from protobuf field <code>bool success = 1;</code>
     * @return bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Success status of the handled event
     *
     * Generated from protobuf field <code>bool success = 1;</code>
     * @param bool $var
     * @return $this
     */
    public function setSuccess($var)
    {
        GPBUtil::checkBool($var);
        $this->success = $var;

        return $this;
    }

}

