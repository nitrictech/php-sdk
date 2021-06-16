<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: kv/v1/kv.proto

namespace Nitric\Proto\KeyValue\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>nitric.kv.v1.KeyValueGetResponse</code>
 */
class KeyValueGetResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The retrieved value
     *
     * Generated from protobuf field <code>.google.protobuf.Struct value = 1;</code>
     */
    protected $value = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Protobuf\Struct $value
     *           The retrieved value
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Kv\V1\Kv::initOnce();
        parent::__construct($data);
    }

    /**
     * The retrieved value
     *
     * Generated from protobuf field <code>.google.protobuf.Struct value = 1;</code>
     * @return \Google\Protobuf\Struct|null
     */
    public function getValue()
    {
        return isset($this->value) ? $this->value : null;
    }

    public function hasValue()
    {
        return isset($this->value);
    }

    public function clearValue()
    {
        unset($this->value);
    }

    /**
     * The retrieved value
     *
     * Generated from protobuf field <code>.google.protobuf.Struct value = 1;</code>
     * @param \Google\Protobuf\Struct $var
     * @return $this
     */
    public function setValue($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Struct::class);
        $this->value = $var;

        return $this;
    }

}

