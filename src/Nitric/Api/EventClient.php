<?php


namespace Nitric\Api;


use Exception;
use Google\Protobuf\Struct;
use Nitric\Proto\Event\v1\NitricEvent;
use Nitric\Proto\Event\v1\EventPublishRequest;
use Nitric\Proto\Event\v1\EventClient as GrpcClient;

class EventClient extends AbstractClient
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
     * Publish an event/message to a topic, which can be subscribed to by other services.
     *
     * @param string $topicName the name of the topic to publish to
     * @param array $payload content of the message to send
     * @param string $payloadType fully qualified name of the event payload type, e.g. io.nitric.example.customer.created
     * @param string|null $id a unique id, used to ensure idempotent processing of events. Defaults to a version 4 UUID.
     * @return string the request id on successful publish
     * @throws Exception
     */
    public function publish(string $topicName, array $payload = [], string $payloadType = "", string $id = null): string
    {
        if ($id == null) {
            // TODO: Move this to Membrane
            $id = $this->gen_uuid();
        }

        $payloadStruct = new Struct();
        try {
            $payloadStruct->mergeFromJsonString(json_encode($payload));
        } catch (Exception $e) {
            throw new Exception("Failed to serialize payload. Details: " . $e->getMessage());
        }

        $event = new NitricEvent();
        $event->setPayload($payloadStruct);
        $event->setPayloadType($payloadType);
        $event->setId($id);

        $publishRequest = new EventPublishRequest();
        $publishRequest->setTopic($topicName);
        $publishRequest->setEvent($event);

        list($reply, $status) = $this->client->Publish($publishRequest)->wait();

        $this->okOrThrow($status);
        return $id;
    }

    // FIXME: This should go away once moved to the membrane.
    private function gen_uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}