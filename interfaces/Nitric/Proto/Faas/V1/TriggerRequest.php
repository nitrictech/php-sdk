<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: faas/v1/faas.proto

namespace Nitric\Proto\Faas\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The server has a trigger for the client to handle
 *
 * Generated from protobuf message <code>nitric.faas.v1.TriggerRequest</code>
 */
class TriggerRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * The data in the trigger
     *
     * Generated from protobuf field <code>bytes data = 1;</code>
     */
    protected $data = '';
    /**
     * Should we supply a mime type for the data?
     * Or rely on context?
     *
     * Generated from protobuf field <code>string mime_type = 2;</code>
     */
    protected $mime_type = '';
    protected $context;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $data
     *           The data in the trigger
     *     @type string $mime_type
     *           Should we supply a mime type for the data?
     *           Or rely on context?
     *     @type \Nitric\Proto\Faas\V1\HttpTriggerContext $http
     *     @type \Nitric\Proto\Faas\V1\TopicTriggerContext $topic
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Faas\V1\Faas::initOnce();
        parent::__construct($data);
    }

    /**
     * The data in the trigger
     *
     * Generated from protobuf field <code>bytes data = 1;</code>
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * The data in the trigger
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
     * Should we supply a mime type for the data?
     * Or rely on context?
     *
     * Generated from protobuf field <code>string mime_type = 2;</code>
     * @return string
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }

    /**
     * Should we supply a mime type for the data?
     * Or rely on context?
     *
     * Generated from protobuf field <code>string mime_type = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setMimeType($var)
    {
        GPBUtil::checkString($var, True);
        $this->mime_type = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.nitric.faas.v1.HttpTriggerContext http = 3;</code>
     * @return \Nitric\Proto\Faas\V1\HttpTriggerContext|null
     */
    public function getHttp()
    {
        return $this->readOneof(3);
    }

    public function hasHttp()
    {
        return $this->hasOneof(3);
    }

    /**
     * Generated from protobuf field <code>.nitric.faas.v1.HttpTriggerContext http = 3;</code>
     * @param \Nitric\Proto\Faas\V1\HttpTriggerContext $var
     * @return $this
     */
    public function setHttp($var)
    {
        GPBUtil::checkMessage($var, \Nitric\Proto\Faas\V1\HttpTriggerContext::class);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.nitric.faas.v1.TopicTriggerContext topic = 4;</code>
     * @return \Nitric\Proto\Faas\V1\TopicTriggerContext|null
     */
    public function getTopic()
    {
        return $this->readOneof(4);
    }

    public function hasTopic()
    {
        return $this->hasOneof(4);
    }

    /**
     * Generated from protobuf field <code>.nitric.faas.v1.TopicTriggerContext topic = 4;</code>
     * @param \Nitric\Proto\Faas\V1\TopicTriggerContext $var
     * @return $this
     */
    public function setTopic($var)
    {
        GPBUtil::checkMessage($var, \Nitric\Proto\Faas\V1\TopicTriggerContext::class);
        $this->writeOneof(4, $var);

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

