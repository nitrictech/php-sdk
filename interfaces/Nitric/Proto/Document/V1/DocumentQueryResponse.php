<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: document/v1/document.proto

namespace Nitric\Proto\Document\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>nitric.document.v1.DocumentQueryResponse</code>
 */
class DocumentQueryResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The retrieved values
     *
     * Generated from protobuf field <code>repeated .nitric.document.v1.Document documents = 1;</code>
     */
    private $documents;
    /**
     * The query paging continuation token, when empty no further results are available
     *
     * Generated from protobuf field <code>map<string, string> paging_token = 2;</code>
     */
    private $paging_token;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Nitric\Proto\Document\V1\Document[]|\Google\Protobuf\Internal\RepeatedField $documents
     *           The retrieved values
     *     @type array|\Google\Protobuf\Internal\MapField $paging_token
     *           The query paging continuation token, when empty no further results are available
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Document\V1\Document::initOnce();
        parent::__construct($data);
    }

    /**
     * The retrieved values
     *
     * Generated from protobuf field <code>repeated .nitric.document.v1.Document documents = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * The retrieved values
     *
     * Generated from protobuf field <code>repeated .nitric.document.v1.Document documents = 1;</code>
     * @param \Nitric\Proto\Document\V1\Document[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDocuments($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Nitric\Proto\Document\V1\Document::class);
        $this->documents = $arr;

        return $this;
    }

    /**
     * The query paging continuation token, when empty no further results are available
     *
     * Generated from protobuf field <code>map<string, string> paging_token = 2;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getPagingToken()
    {
        return $this->paging_token;
    }

    /**
     * The query paging continuation token, when empty no further results are available
     *
     * Generated from protobuf field <code>map<string, string> paging_token = 2;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setPagingToken($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->paging_token = $arr;

        return $this;
    }

}
