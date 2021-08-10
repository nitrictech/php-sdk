<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: secret/v1/secret.proto

namespace Nitric\Proto\Secret\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The secret container
 *
 * Generated from protobuf message <code>nitric.secret.v1.Secret</code>
 */
class Secret extends \Google\Protobuf\Internal\Message
{
    /**
     * The secret name
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    protected $name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           The secret name
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Secret\V1\Secret::initOnce();
        parent::__construct($data);
    }

    /**
     * The secret name
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The secret name
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

}

