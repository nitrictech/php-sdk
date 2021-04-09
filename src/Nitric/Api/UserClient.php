<?php


namespace Nitric\Api;


use Nitric\Proto\Auth\V1\UserCreateRequest;
use Nitric\Proto\Auth\V1\UserClient as GrpcClient;

class UserClient extends AbstractClient
{
    private GrpcClient $client;

    public function __construct(GrpcClient $client = null)
    {
        parent::__construct();
        if ($client) {
            $this->client = $client;
        } else {
            $this->client = new GrpcClient($this->hostname, $this->opts);
        }
    }

    public function create(string $tenant, string $userID, string $email, string $password)
    {
        $request = new UserCreateRequest();
        $request->setTenant($tenant);
        $request->setId($userID);
        $request->setEmail($email);
        $request->setPassword($password);

        list($reply, $status) = $this->client->Create($request)->wait();

        $this->okOrThrow($status);
    }
}