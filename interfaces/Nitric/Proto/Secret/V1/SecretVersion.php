<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: secret/v1/secret.proto

namespace Nitric\Proto\Secret\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A version of a secret
 *
 * Generated from protobuf message <code>nitric.secret.v1.SecretVersion</code>
 */
class SecretVersion extends \Google\Protobuf\Internal\Message
{
    /**
     * Reference to the secret container 
     *
     * Generated from protobuf field <code>.nitric.secret.v1.Secret secret = 1;</code>
     */
    protected $secret = null;
    /**
     * The secret version
     *
     * Generated from protobuf field <code>string version = 2;</code>
     */
    protected $version = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Nitric\Proto\Secret\V1\Secret $secret
     *           Reference to the secret container 
     *     @type string $version
     *           The secret version
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Secret\V1\Secret::initOnce();
        parent::__construct($data);
    }

    /**
     * Reference to the secret container 
     *
     * Generated from protobuf field <code>.nitric.secret.v1.Secret secret = 1;</code>
     * @return \Nitric\Proto\Secret\V1\Secret|null
     */
    public function getSecret()
    {
        return $this->secret;
    }

    public function hasSecret()
    {
        return isset($this->secret);
    }

    public function clearSecret()
    {
        unset($this->secret);
    }

    /**
     * Reference to the secret container 
     *
     * Generated from protobuf field <code>.nitric.secret.v1.Secret secret = 1;</code>
     * @param \Nitric\Proto\Secret\V1\Secret $var
     * @return $this
     */
    public function setSecret($var)
    {
        GPBUtil::checkMessage($var, \Nitric\Proto\Secret\V1\Secret::class);
        $this->secret = $var;

        return $this;
    }

    /**
     * The secret version
     *
     * Generated from protobuf field <code>string version = 2;</code>
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * The secret version
     *
     * Generated from protobuf field <code>string version = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setVersion($var)
    {
        GPBUtil::checkString($var, True);
        $this->version = $var;

        return $this;
    }

}
