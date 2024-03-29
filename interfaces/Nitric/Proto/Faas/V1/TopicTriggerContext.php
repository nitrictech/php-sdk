<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: faas/v1/faas.proto

namespace Nitric\Proto\Faas\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>nitric.faas.v1.TopicTriggerContext</code>
 */
class TopicTriggerContext extends \Google\Protobuf\Internal\Message
{
    /**
     * The topic the message was published for
     *
     * Generated from protobuf field <code>string topic = 1;</code>
     */
    protected $topic = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $topic
     *           The topic the message was published for
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Faas\V1\Faas::initOnce();
        parent::__construct($data);
    }

    /**
     * The topic the message was published for
     *
     * Generated from protobuf field <code>string topic = 1;</code>
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * The topic the message was published for
     *
     * Generated from protobuf field <code>string topic = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setTopic($var)
    {
        GPBUtil::checkString($var, True);
        $this->topic = $var;

        return $this;
    }

}

