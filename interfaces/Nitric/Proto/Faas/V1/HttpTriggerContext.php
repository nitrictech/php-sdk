<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: faas/v1/faas.proto

namespace Nitric\Proto\Faas\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>nitric.faas.v1.HttpTriggerContext</code>
 */
class HttpTriggerContext extends \Google\Protobuf\Internal\Message
{
    /**
     * The request method
     *
     * Generated from protobuf field <code>string method = 1;</code>
     */
    protected $method = '';
    /**
     * The path of the request
     *
     * Generated from protobuf field <code>string path = 2;</code>
     */
    protected $path = '';
    /**
     * The request headers
     *
     * Generated from protobuf field <code>map<string, string> headers = 3;</code>
     */
    private $headers;
    /**
     * The query params (if parseable by the membrane)
     *
     * Generated from protobuf field <code>map<string, string> query_params = 4;</code>
     */
    private $query_params;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $method
     *           The request method
     *     @type string $path
     *           The path of the request
     *     @type array|\Google\Protobuf\Internal\MapField $headers
     *           The request headers
     *     @type array|\Google\Protobuf\Internal\MapField $query_params
     *           The query params (if parseable by the membrane)
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Faas\V1\Faas::initOnce();
        parent::__construct($data);
    }

    /**
     * The request method
     *
     * Generated from protobuf field <code>string method = 1;</code>
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * The request method
     *
     * Generated from protobuf field <code>string method = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setMethod($var)
    {
        GPBUtil::checkString($var, True);
        $this->method = $var;

        return $this;
    }

    /**
     * The path of the request
     *
     * Generated from protobuf field <code>string path = 2;</code>
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * The path of the request
     *
     * Generated from protobuf field <code>string path = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setPath($var)
    {
        GPBUtil::checkString($var, True);
        $this->path = $var;

        return $this;
    }

    /**
     * The request headers
     *
     * Generated from protobuf field <code>map<string, string> headers = 3;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * The request headers
     *
     * Generated from protobuf field <code>map<string, string> headers = 3;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setHeaders($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->headers = $arr;

        return $this;
    }

    /**
     * The query params (if parseable by the membrane)
     *
     * Generated from protobuf field <code>map<string, string> query_params = 4;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getQueryParams()
    {
        return $this->query_params;
    }

    /**
     * The query params (if parseable by the membrane)
     *
     * Generated from protobuf field <code>map<string, string> query_params = 4;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setQueryParams($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->query_params = $arr;

        return $this;
    }

}

