<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: storage/v1/storage.proto

namespace Nitric\Proto\Storage\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Returned storage item
 *
 * Generated from protobuf message <code>nitric.storage.v1.StorageReadResponse</code>
 */
class StorageReadResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The body bytes of the retrieved storage item
     *
     * Generated from protobuf field <code>bytes body = 1;</code>
     */
    protected $body = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $body
     *           The body bytes of the retrieved storage item
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Storage\V1\Storage::initOnce();
        parent::__construct($data);
    }

    /**
     * The body bytes of the retrieved storage item
     *
     * Generated from protobuf field <code>bytes body = 1;</code>
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * The body bytes of the retrieved storage item
     *
     * Generated from protobuf field <code>bytes body = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setBody($var)
    {
        GPBUtil::checkString($var, False);
        $this->body = $var;

        return $this;
    }

}

