<?php

namespace Nitric\V1;

use Google\Protobuf\Internal\Message;
use Grpc\UnaryCall;
use Nitric\BaseClient\V1\Documents\DocumentGetResponse;
use Nitric\V1\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use stdClass;
use const Grpc\STATUS_NOT_FOUND;
use const Grpc\STATUS_OK;


class DocumentClientTest extends TestCase
{

    public function testCreateDocument()
    {
        $docs = new DocumentClient();
        $obj = new \stdClass();
        $obj->testing = "some value";
        $docs->create("welcomed", "test2", $obj);
        $this->assertTrue(true);
    }

    public function testGetDocument()
    {
        $mockDocument = new stdClass();
        $mockDocument->stringKey = "string value";
        $mockDocument->intKey = 45;
        $mockDocument->floatKey = 45.5;

        $stubResponse = new DocumentGetResponse();
        $stubResponse->setDocument(AbstractClient::structFromClass($mockDocument));

        $stubUnaryCall = $this->stubCall(response: $stubResponse);

        $stubGrpcDocClient = $this->createMock(\Nitric\BaseClient\V1\Documents\DocumentClient::class);
        $stubGrpcDocClient
            ->expects($this->once())
            ->method('Get')
//            ->with($this->objectHasAttribute('payload'))
            ->willReturn($stubUnaryCall);

        $documentClient = new DocumentClient($stubGrpcDocClient);
        $document = $documentClient->get(
            collection: "test-collection",
            key: "test-key"
        );

        // Ensure the document is returned.
        $this->assertEquals($mockDocument, $document);
    }

    public function testGetDocumentThatDoesntExist() {
        $stubUnaryCall = $this->stubCall(STATUS_NOT_FOUND);

        $stubGrpcDocClient = $this->createMock(\Nitric\BaseClient\V1\Documents\DocumentClient::class);
        $stubGrpcDocClient
            ->expects($this->once())
            ->method('Get')
            ->willReturn($stubUnaryCall);
        $documentClient = new DocumentClient($stubGrpcDocClient);

        try {
            $document = $documentClient->get(
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
