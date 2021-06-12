<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: storage/v1/storage.proto

namespace Nitric\Proto\Storage\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request to put (create/update) a storage item
 *
 * Generated from protobuf message <code>nitric.storage.v1.StorageWriteRequest</code>
 */
class StorageWriteRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Nitric name of the bucket to store in
     *  this will be automatically resolved to the provider specific bucket identifier.
     *
     * Generated from protobuf field <code>string bucketName = 1;</code>
     */
    protected $bucketName = '';
    /**
     * Key to store the item under
     *
     * Generated from protobuf field <code>string key = 2;</code>
     */
    protected $key = '';
    /**
     * bytes array to store
     *
     * Generated from protobuf field <code>bytes body = 3;</code>
     */
    protected $body = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $bucketName
     *           Nitric name of the bucket to store in
     *            this will be automatically resolved to the provider specific bucket identifier.
     *     @type string $key
     *           Key to store the item under
     *     @type string $body
     *           bytes array to store
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Storage\V1\Storage::initOnce();
        parent::__construct($data);
    }

    /**
     * Nitric name of the bucket to store in
     *  this will be automatically resolved to the provider specific bucket identifier.
     *
     * Generated from protobuf field <code>string bucketName = 1;</code>
     * @return string
     */
    public function getBucketName()
    {
        return $this->bucketName;
    }

    /**
     * Nitric name of the bucket to store in
     *  this will be automatically resolved to the provider specific bucket identifier.
     *
     * Generated from protobuf field <code>string bucketName = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setBucketName($var)
    {
        GPBUtil::checkString($var, True);
        $this->bucketName = $var;

        return $this;
    }

    /**
     * Key to store the item under
     *
     * Generated from protobuf field <code>string key = 2;</code>
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Key to store the item under
     *
     * Generated from protobuf field <code>string key = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setKey($var)
    {
        GPBUtil::checkString($var, True);
        $this->key = $var;

        return $this;
    }

    /**
     * bytes array to store
     *
     * Generated from protobuf field <code>bytes body = 3;</code>
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * bytes array to store
     *
     * Generated from protobuf field <code>bytes body = 3;</code>
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
