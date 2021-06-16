<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: storage/v1/storage.proto

namespace Nitric\Proto\Storage\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request to delete a storage item
 *
 * Generated from protobuf message <code>nitric.storage.v1.StorageDeleteRequest</code>
 */
class StorageDeleteRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Name of the bucket to delete from
     *
     * Generated from protobuf field <code>string bucketName = 1;</code>
     */
    protected $bucketName = '';
    /**
     * Key of item to delete
     *
     * Generated from protobuf field <code>string key = 2;</code>
     */
    protected $key = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $bucketName
     *           Name of the bucket to delete from
     *     @type string $key
     *           Key of item to delete
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Storage\V1\Storage::initOnce();
        parent::__construct($data);
    }

    /**
     * Name of the bucket to delete from
     *
     * Generated from protobuf field <code>string bucketName = 1;</code>
     * @return string
     */
    public function getBucketName()
    {
        return $this->bucketName;
    }

    /**
     * Name of the bucket to delete from
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
     * Key of item to delete
     *
     * Generated from protobuf field <code>string key = 2;</code>
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Key of item to delete
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

}

