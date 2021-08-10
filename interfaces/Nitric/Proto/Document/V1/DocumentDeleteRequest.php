<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: document/v1/document.proto

namespace Nitric\Proto\Document\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>nitric.document.v1.DocumentDeleteRequest</code>
 */
class DocumentDeleteRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Key of the document to delete
     *
     * Generated from protobuf field <code>.nitric.document.v1.Key key = 1;</code>
     */
    protected $key = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Nitric\Proto\Document\V1\Key $key
     *           Key of the document to delete
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Document\V1\Document::initOnce();
        parent::__construct($data);
    }

    /**
     * Key of the document to delete
     *
     * Generated from protobuf field <code>.nitric.document.v1.Key key = 1;</code>
     * @return \Nitric\Proto\Document\V1\Key|null
     */
    public function getKey()
    {
        return $this->key;
    }

    public function hasKey()
    {
        return isset($this->key);
    }

    public function clearKey()
    {
        unset($this->key);
    }

    /**
     * Key of the document to delete
     *
     * Generated from protobuf field <code>.nitric.document.v1.Key key = 1;</code>
     * @param \Nitric\Proto\Document\V1\Key $var
     * @return $this
     */
    public function setKey($var)
    {
        GPBUtil::checkMessage($var, \Nitric\Proto\Document\V1\Key::class);
        $this->key = $var;

        return $this;
    }

}

