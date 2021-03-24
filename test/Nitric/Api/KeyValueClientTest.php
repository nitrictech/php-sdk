<?php

namespace Nitric\Api;

use Google\Protobuf\Internal\Message;
use Grpc\UnaryCall;
use Nitric\Proto\KeyValue\V1\KeyValueGetResponse;
use Nitric\Api\Exception\NotFoundException;
use Nitric\Proto\KeyValue\V1\KeyValuePutResponse;
use PHPUnit\Framework\TestCase;
use stdClass;
use const Grpc\STATUS_NOT_FOUND;
use const Grpc\STATUS_OK;


class KeyValueClientTest extends TestCase
{

    public function testPutValue()
    {
        $stubUnaryCall = $this->stubCall(response: new KeyValuePutResponse());

        $stubGrpcKVClient = $this->createMock(\Nitric\Proto\KeyValue\V1\KeyValueClient::class);
        $stubGrpcKVClient
            ->expects($this->once())
            ->method('Put')
//            ->with($this->objectHasAttribute('payload'))
            ->willReturn($stubUnaryCall);

        $kvc = new KeyValueClient($stubGrpcKVClient);
        $obj = new \stdClass();
        $obj->testing = "some value";
        $kvc->put("welcomed", "test2", $obj);
        $this->assertTrue(true);
    }

    public function testGetKeyValue()
    {
        $testValue = new stdClass();
        $testValue->stringKey = "string value";
        $testValue->intKey = 45;
        $testValue->floatKey = 45.5;

        $stubResponse = new KeyValueGetResponse();
        $stubResponse->setValue(AbstractClient::structFromClass($testValue));

        $stubUnaryCall = $this->stubCall(response: $stubResponse);

        $stubGrpcKVClient = $this->createMock(\Nitric\Proto\KeyValue\V1\KeyValueClient::class);
        $stubGrpcKVClient
            ->expects($this->once())
            ->method('Get')
//            ->with($this->objectHasAttribute('payload'))
            ->willReturn($stubUnaryCall);

        $kvc = new KeyValueClient($stubGrpcKVClient);
        $value = $kvc->get(
            collection: "test-collection",
            key: "test-key"
        );

        // Ensure the value is returned.
        $this->assertEquals($testValue, $value);
    }

    public function testGetKeyValueThatDoesntExist() {
        $stubUnaryCall = $this->stubCall(STATUS_NOT_FOUND);

        $stubGrpcDocClient = $this->createMock(\Nitric\Proto\KeyValue\V1\KeyValueClient::class);
        $stubGrpcDocClient
            ->expects($this->once())
            ->method('Get')
            ->willReturn($stubUnaryCall);
        $kvc = new KeyValueClient($stubGrpcDocClient);

        try {
            $value = $kvc->get(
                collection: "test-collection",
                key: "test-key"
            );
            $this->assertFalse(true); // Should not reach here.
        } catch (NotFoundException $e) {
        }
    }

    private function stubCall(int $statusCode = STATUS_OK, string $statusMsg = "", Message|null $response = null): UnaryCall {
        $status = new stdClass();
        $status->code = $statusCode;
        $status->details = $statusMsg;

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                $response,
                $status
            ]);

        return $stubUnaryCall;
    }
}
