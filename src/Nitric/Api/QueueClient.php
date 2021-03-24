<?php


namespace Nitric\Api;


use Exception;
use Nitric\Proto\Queue\v1\NitricTask;
use Nitric\Proto\Queue\v1\QueueClient as GrpcClient;
use Nitric\Proto\Queue\v1\QueueReceiveRequest;
use Nitric\Proto\Queue\v1\QueueReceiveResponse;
use Nitric\Proto\Queue\v1\QueueSendBatchRequest;
use Nitric\Proto\Queue\v1\QueueSendBatchResponse;

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
     * Send a collection of tasks to a queue, which can be received by other services.
     *
     * @param string $queueName the name of the queue to publish to
     * @param Task[] $tasks The tasks to push to the queue
     * @return FailedTask[] containing a list containing details of any messages that failed to publish.
     * @throws Exception
     */
    public function sendBatch(string $queueName, Task...$tasks): array
    {
        $request = new QueueSendBatchRequest();
        $request->setQueue($queueName);

        $nitricTasks = array_map(function (Task $task) {
            $ne = new NitricTask();
            $ne->setPayload(
                self::structFromClass($task->getPayload())
            );
            $ne->setPayloadType($task->getPayloadType());
            $ne->setId($task->getId());
            return $ne;
        }, $tasks);

        $request->setTasks($nitricTasks);

        [$response, $status] = $this->client->SendBatch($request)->wait();
        $this->okOrThrow($status);
        // Add type hint to the response object
        $response = (fn($r): QueueSendBatchResponse => $r)($response);

        $failed = array_map(function (\Nitric\Proto\Queue\V1\FailedTask $t) {
            $task = new Task();
            $task->setId($t->getTask()->getId());
            $task->setPayloadType($t->getTask()->getPayloadType());
            $task->setPayload(AbstractClient::classFromStruct($t->getTask()->getPayload()));

            $failedTask = new FailedTask();
            $failedTask->setMessage($t->getMessage());
            $failedTask->setTask($task);
            return $failedTask;

        }, (array)$response->getFailedTasks());

        return new $failed;
    }

    /**
     * Pop 1 or more items from the specified queue up to the depth limit.
     *
     * Received Tasks are leased for a limited period of time, where they may be worked on.
     * Once complete or failed they must be completed using the request specific leaseId.
     *
     * If the lease on a task expires before it is completed or the lease is extended the task will be
     * returned to the queue for reprocessing or forwarded to a dead-letter queue if retries have been exceeded.
     *
     * @param string $queue Nitric name for the queue. This will be automatically resolved to the provider specific identifier.
     * @param int $depth The maximum number of queue items to return. Default: 1, Min: 1.
     * @return array Queue items popped from the queue.
     * @throws Exception
     */
    public function receive(string $queue, int $depth = 1): array
    {
        if ($depth < 1) {
            $depth = 1;
        }
        $request = new QueueReceiveRequest();
        $request->setQueue($queue);
        $request->setDepth($depth);

        [$response, $status] = $this->client->Receive($request)->wait();
        $this->okOrThrow($status);
        $response = (fn($r): QueueReceiveResponse => $r)($response);

        return array_map(function (NitricTask $i) {
            return new Task(
                payload: AbstractClient::classFromStruct($i->getPayload()),
                payloadType: $i->getPayloadType(),
                id: $i->getId(),
                leaseID: $i->getLeaseId()
            );
        }, (array)$response->getTasks());
    }
}

