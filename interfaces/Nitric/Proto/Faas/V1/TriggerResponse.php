<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: faas/v1/faas.proto

namespace Nitric\Proto\Faas\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The worker has successfully processed a trigger
 *
 * Generated from protobuf message <code>nitric.faas.v1.TriggerResponse</code>
 */
class TriggerResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The data returned in the response
     *
     * Generated from protobuf field <code>bytes data = 1;</code>
     */
    protected $data = '';
    protected $context;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $data
     *           The data returned in the response
     *     @type \Nitric\Proto\Faas\V1\HttpResponseContext $http
     *           response to a http request
     *     @type \Nitric\Proto\Faas\V1\TopicResponseContext $topic
     *           response to a topic trigger
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Faas\V1\Faas::initOnce();
        parent::__construct($data);
    }

    /**
     * The data returned in the response
     *
     * Generated from protobuf field <code>bytes data = 1;</code>
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * The data returned in the response
     *
     * Generated from protobuf field <code>bytes data = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setData($var)
    {
        GPBUtil::checkString($var, False);
        $this->data = $var;

        return $this;
    }

    /**
     * response to a http request
     *
     * Generated from protobuf field <code>.nitric.faas.v1.HttpResponseContext http = 10;</code>
     * @return \Nitric\Proto\Faas\V1\HttpResponseContext|null
     */
    public function getHttp()
    {
        return $this->readOneof(10);
    }

    public function hasHttp()
    {
        return $this->hasOneof(10);
    }

    /**
     * response to a http request
     *
     * Generated from protobuf field <code>.nitric.faas.v1.HttpResponseContext http = 10;</code>
     * @param \Nitric\Proto\Faas\V1\HttpResponseContext $var
     * @return $this
     */
    public function setHttp($var)
    {
        GPBUtil::checkMessage($var, \Nitric\Proto\Faas\V1\HttpResponseContext::class);
        $this->writeOneof(10, $var);

        return $this;
    }

    /**
     * response to a topic trigger
     *
     * Generated from protobuf field <code>.nitric.faas.v1.TopicResponseContext topic = 11;</code>
     * @return \Nitric\Proto\Faas\V1\TopicResponseContext|null
     */
    public function getTopic()
    {
        return $this->readOneof(11);
    }

    public function hasTopic()
    {
        return $this->hasOneof(11);
    }

    /**
     * response to a topic trigger
     *
     * Generated from protobuf field <code>.nitric.faas.v1.TopicResponseContext topic = 11;</code>
     * @param \Nitric\Proto\Faas\V1\TopicResponseContext $var
     * @return $this
     */
    public function setTopic($var)
    {
        GPBUtil::checkMessage($var, \Nitric\Proto\Faas\V1\TopicResponseContext::class);
        $this->writeOneof(11, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->whichOneof("context");
    }

}

