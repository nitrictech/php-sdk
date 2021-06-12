<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Nitric\Proto\Auth\V1;

/**
 * Service for user management activities, such as creating and deleting users
 */
class UserClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create a new user in a tenant
     * @param \Nitric\Proto\Auth\V1\UserCreateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Create(\Nitric\Proto\Auth\V1\UserCreateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/nitric.auth.v1.User/Create',
        $argument,
        ['\Nitric\Proto\Auth\V1\UserCreateResponse', 'decode'],
        $metadata, $options);
    }

}
