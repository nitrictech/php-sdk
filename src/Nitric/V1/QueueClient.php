<?php


namespace Nitric\V1;


use Exception;
use Nitric\BaseClient\V1\Common\NitricEvent;
use Nitric\BaseClient\V1\Queues\NitricQueueItem;
use Nitric\BaseClient\V1\Queues\QueueBatchPushRequest;
use Nitric\BaseClient\V1\Queues\QueueBatchPushResponse;
use Nitric\BaseClient\V1\Queues\QueueClient as GrpcClient;
use Nitric\BaseClient\V1\Queues\QueuePopRequest;
use Nitric\BaseClient\V1\Queues\QueuePopResponse;

class QueueClient extends AbstractClient
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
     * Push a collection of events to a queue, which can be retrieved by other services.
     *
     * @param string $queueName the name of the queue to publish to
     * @param Event[] $events The events to push to the queue
     * @return PushResponse containing a list containing details of any messages that failed to publish.
     * @throws Exception
     */
    public function batchPush(string $queueName, Event... $events): PushResponse
    {
        $request = new QueueBatchPushRequest();
        $request->setQueue($queueName);

        $nitricEvents = array_map(function (Event $e) {
            $ne = new NitricEvent();
            $ne->setPayload(
                Utils::structFromClass($e->getPayload())
            );
            $ne->setPayloadType($e->getPayloadType());
            $ne->setRequestId($e->getRequestID());
            return $ne;
        }, $events);

        $request->setEvents($nitricEvents);

        [$response, $status] = $this->client->BatchPush($request)->wait();
        $this->checkStatus($status);
        // Add type hint to the response object
        $response = (fn($r): QueueBatchPushResponse => $r)($response);

        $failedEvents = array_map(function (\Nitric\BaseClient\V1\Queues\FailedEvent $e) {
            $fe = new FailedEvent();
            $fe->setMessage($e->getMessage());

            $ne = new Event();
            $ne->setRequestID($e->getEvent()->getRequestId());
            $ne->setPayloadType($e->getEvent()->setPayloadType());
            $ne->setPayload(Utils::classFromStruct($e->getEvent()->getPayload()));

            $fe->setEvent($ne);
            return $fe;

        }, (array)$response->getFailedEvents());

        return new PushResponse($failedEvents);
    }

    /**
     * Pop 1 or more items from the specified queue up to the depth limit.
     *
     * Queue items are Nitric Events that are leased for a limited period of time, where they may be worked on.
     * Once complete or failed they must be acknowledged using the request specific leaseId.
     *
     * If the lease on a queue item expires before it is acknowledged or the lease is extended the event will be
     * returned to the queue for reprocessing.
     *
     * @param string $queueName Nitric name for the queue. This will be automatically resolved to the provider specific identifier.
     * @param int $depth The maximum number of queue items to return. Default: 1, Min: 1.
     * @return array Queue items popped from the queue.
     * @throws Exception
     */
    public function pop(string $queueName, int $depth = 1): array
    {
        if ($depth < 1) {
            $depth = 1;
        }
        $request = new QueuePopRequest();
        $request->setQueue($queueName);
        $request->setDepth($depth);

        [$response, $status] = $this->client->Pop($request)->wait();
        $this->checkStatus($status);
        $response = (fn($r): QueuePopResponse => $r)($response);

        return array_map(function(NitricQueueItem $i) {
            return new QueueItem(
                new Event(
                    payload: Utils::classFromStruct($i->getEvent()->getPayload()),
                    payloadType: $i->getEvent()->getPayloadType(),
                    requestID: $i->getEvent()->getRequestId()
                ),
                $i->getLeaseId()
            );
        }, (array)$response->getItems());
    }
}

