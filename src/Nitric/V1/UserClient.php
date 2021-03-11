<?php


namespace Nitric\V1;


use Nitric\BaseClient\V1\Auth\UserCreateRequest;
use \Nitric\BaseClient\V1\Auth\UserClient as GrpcClient;

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

    public function createUser(string $tenant, string $userID, string $email, string $password)
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