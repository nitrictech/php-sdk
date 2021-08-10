<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: document/v1/document.proto

namespace Nitric\Proto\Document\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>nitric.document.v1.Collection</code>
 */
class Collection extends \Google\Protobuf\Internal\Message
{
    /**
     * The collection name
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    protected $name = '';
    /**
     * Optional parent key, required when the collection is a sub-collection of another document
     *
     * Generated from protobuf field <code>.nitric.document.v1.Key parent = 2;</code>
     */
    protected $parent = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           The collection name
     *     @type \Nitric\Proto\Document\V1\Key $parent
     *           Optional parent key, required when the collection is a sub-collection of another document
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Document\V1\Document::initOnce();
        parent::__construct($data);
    }

    /**
     * The collection name
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The collection name
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

    /**
     * Optional parent key, required when the collection is a sub-collection of another document
     *
     * Generated from protobuf field <code>.nitric.document.v1.Key parent = 2;</code>
     * @return \Nitric\Proto\Document\V1\Key|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function hasParent()
    {
        return isset($this->parent);
    }

    public function clearParent()
    {
        unset($this->parent);
    }

    /**
     * Optional parent key, required when the collection is a sub-collection of another document
     *
     * Generated from protobuf field <code>.nitric.document.v1.Key parent = 2;</code>
     * @param \Nitric\Proto\Document\V1\Key $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkMessage($var, \Nitric\Proto\Document\V1\Key::class);
        $this->parent = $var;

        return $this;
    }

}

