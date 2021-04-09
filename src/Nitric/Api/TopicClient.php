<?php


namespace Nitric\Api;


use Nitric\Proto\Event\V1\NitricTopic;
use Nitric\Proto\Event\V1\TopicClient as GrpcClient;
use Nitric\Proto\Event\V1\TopicListRequest;
use Nitric\Proto\Event\V1\TopicListResponse;

class TopicClient extends AbstractClient
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

    /**
     * Return a list of topics available for publishing or subscriptions.
     * @return string[] array of topic names
     * @throws \Exception
     */
    public function list(): array {
        [$response, $status] = $this->client->List(new TopicListRequest())->wait();
        $this->okOrThrow($status);
        $response = (fn($r): TopicListResponse => $r)($response);

        return array_map(function (NitricTopic $t): string {
            return $t->getName();
        }, (array)$response->getTopics());
    }
}