<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: auth/v1/auth.proto

namespace Nitric\Proto\Auth\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request to create a new user in the given tenant (user pool).
 *
 * Generated from protobuf message <code>nitric.auth.v1.UserCreateRequest</code>
 */
class UserCreateRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string tenant = 1;</code>
     */
    protected $tenant = '';
    /**
     * Generated from protobuf field <code>string id = 2;</code>
     */
    protected $id = '';
    /**
     * Generated from protobuf field <code>string email = 3;</code>
     */
    protected $email = '';
    /**
     * Generated from protobuf field <code>string password = 4;</code>
     */
    protected $password = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $tenant
     *     @type string $id
     *     @type string $email
     *     @type string $password
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Auth\V1\Auth::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string tenant = 1;</code>
     * @return string
     */
    public function getTenant()
    {
        return $this->tenant;
    }

    /**
     * Generated from protobuf field <code>string tenant = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setTenant($var)
    {
        GPBUtil::checkString($var, True);
        $this->tenant = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string id = 2;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Generated from protobuf field <code>string id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string email = 3;</code>
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Generated from protobuf field <code>string email = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setEmail($var)
    {
        GPBUtil::checkString($var, True);
        $this->email = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string password = 4;</code>
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Generated from protobuf field <code>string password = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setPassword($var)
    {
        GPBUtil::checkString($var, True);
        $this->password = $var;

        return $this;
    }

}
