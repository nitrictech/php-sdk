<?php


namespace Nitric\Api;


use Exception;
use Grpc\UnaryCall;
use Nitric\Api\Exception\NotFoundException;
use Nitric\Proto\Document\V1\Collection;
use Nitric\Proto\Document\V1\Document;
use Nitric\Proto\Document\V1\DocumentDeleteRequest;
use Nitric\Proto\Document\V1\DocumentDeleteResponse;
use Nitric\Proto\Document\V1\DocumentGetRequest;
use Nitric\Proto\Document\V1\DocumentGetResponse;
use Nitric\Proto\Document\V1\DocumentQueryRequest;
use Nitric\Proto\Document\V1\DocumentQueryResponse;
use Nitric\Proto\Document\V1\DocumentServiceClient;
use Nitric\Proto\Document\V1\DocumentSetRequest;
use Nitric\Proto\Document\V1\DocumentSetResponse;
use Nitric\Proto\Document\V1\Expression;
use Nitric\Proto\Document\V1\ExpressionValue;
use Nitric\Proto\Document\V1\Key;
use Nitric\ProtoUtils\Utils;
use PHPUnit\Framework\TestCase;
use stdClass;
use const Grpc\STATUS_NOT_FOUND;
use const Grpc\STATUS_OK;

/**
 * @covers \Nitric\Api\Documents
 */
class DocumentsTest extends TestCase
{
    public function testCreateClient()
    {
        $testClient = $this->createMock(DocumentServiceClient::class);
        $documents = new Documents(documentClient: $testClient);
        $this->assertEquals($testClient, $documents->_baseDocumentClient);
    }

    public function testCreateCollectionRef()
    {
        $ref = (new Documents())->collection("the-collection");
        $this->assertFalse($ref->isSubCollection());
        $this->assertEquals("the-collection", $ref->getName());
        $this->assertEquals(null, $ref->getParent());
    }

    public function testCreateDocRef()
    {
        $col = (new Documents())->collection("the-collection");
        $ref = $col->doc("the-doc");
        $this->assertEquals("the-doc", $ref->getId());
        $this->assertEquals($col, $ref->getParent());
    }

    public function testSetDocument()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $testResponse = new DocumentSetResponse();

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                $testResponse, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcQueueClient = $this->createMock(DocumentServiceClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('Set')
            ->with($this->callback(function (DocumentSetRequest $request) {
                $this->assertEquals("test-doc", $request->getKey()->getId());
                $this->assertEquals("test-collection", $request->getKey()->getCollection()->getName());
                $this->assertEquals('{"value":"test-value"}', $request->getContent()->serializeToJsonString());
                return true;
            }))
            ->willReturn($stubUnaryCall);

        $content = new stdClass();
        $content->value = "test-value";

        $docs = new Documents(documentClient: $stubGrpcQueueClient);
        $docs->collection('test-collection')->doc('test-doc')->set($content);
    }

    public function testGetDocument()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $content = new stdClass();
        $content->value = "test-value";

        $mockCollection = new Collection();
        $mockCollection->setName("test-collection");

        $mockKey = new Key();
        $mockKey->setId("test-doc");
        $mockKey->setCollection($mockCollection);

        $mockDoc = new Document();
        $mockDoc->setContent(Utils::structFromClass($content));
        $mockDoc->setKey($mockKey);

        $testResponse = new DocumentGetResponse();
        $testResponse->setDocument($mockDoc);

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                $testResponse, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcQueueClient = $this->createMock(DocumentServiceClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('Get')
            ->with($this->callback(function (DocumentGetRequest $request) {
                $this->assertEquals("test-doc", $request->getKey()->getId());
                $this->assertEquals("test-collection", $request->getKey()->getCollection()->getName());
                return true;
            }))
            ->willReturn($stubUnaryCall);

        $content = new stdClass();
        $content->value = "test-value";

        $docs = new Documents(documentClient: $stubGrpcQueueClient);
        $returnedDoc = $docs->collection('test-collection')->doc('test-doc')->get();
        $this->assertEquals("test-value", $returnedDoc->getContent()->value);
        $this->assertEquals("test-doc", $returnedDoc->getRef()->getId());
    }

    public function testGetDocumentWhichDoesntExist()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_NOT_FOUND;

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                null, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcQueueClient = $this->createMock(DocumentServiceClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('Get')
            ->with($this->callback(function (DocumentGetRequest $request) {
                $this->assertEquals("test-doc", $request->getKey()->getId());
                $this->assertEquals("test-collection", $request->getKey()->getCollection()->getName());
                return true;
            }))
            ->willReturn($stubUnaryCall);

        $content = new stdClass();
        $content->value = "test-value";

        $docs = new Documents(documentClient: $stubGrpcQueueClient);
        $this->expectException(NotFoundException::class);
        $docs->collection('test-collection')->doc('test-doc')->get();
    }

    public function testDeleteDocument()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $testResponse = new DocumentDeleteResponse();

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                $testResponse, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcQueueClient = $this->createMock(DocumentServiceClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('Delete')
            ->with($this->callback(function (DocumentDeleteRequest $request) {
                $this->assertEquals("test-doc", $request->getKey()->getId());
                $this->assertEquals("test-collection", $request->getKey()->getCollection()->getName());
                return true;
            }))
            ->willReturn($stubUnaryCall);

        $docs = new Documents(documentClient: $stubGrpcQueueClient);
        $docs->collection('test-collection')->doc('test-doc')->delete();
    }

    public function testCreateSubCollectionBeyondMaxDepth()
    {
        $valid = (new Documents())->collection('1')->doc('a')->collection('2')->doc('b');
        $this->expectException(Exception::class);
        // This should produce a depth of 2 (a collection with 2 parent collections), which is beyond the current max of 1.
        $valid->collection('3');
    }

    public function testGetSubCollectionDocument()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $content = new stdClass();
        $content->value = "test-value";

        $mockDoc = new Document();
        $mockDoc->setContent(Utils::structFromClass($content));
        $mockDoc->setKey((new Key())
            ->setId("test-doc")
            ->setCollection((new Collection())->setName("test-collection")));

        $testResponse = new DocumentGetResponse();
        $testResponse->setDocument($mockDoc);

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                $testResponse, # Reply
                $mockStatusObj # Status
            ]);

        $stubGrpcQueueClient = $this->createMock(DocumentServiceClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('Get')
            ->with($this->callback(function (DocumentGetRequest $request) {
                $this->assertEquals("sub-doc", $request->getKey()->getId());
                $this->assertEquals("sub-col", $request->getKey()->getCollection()->getName());
                $this->assertEquals("parent-doc", $request->getKey()->getCollection()->getParent()->getId());
                $this->assertEquals("parent-col", $request->getKey()->getCollection()->getParent()->getCollection()->getName());
                return true;
            }))
            ->willReturn($stubUnaryCall);

        $content = new stdClass();
        $content->value = "test-value";

        $docs = new Documents(documentClient: $stubGrpcQueueClient);
        $returnedDoc = $docs
            ->collection('parent-col')
            ->doc('parent-doc')
            ->collection('sub-col')
            ->doc('sub-doc')
            ->get();
        $this->assertEquals("test-value", $returnedDoc->getContent()->value);
        $this->assertEquals("test-doc", $returnedDoc->getRef()->getId());
    }

    public function testQuery()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $content = new stdClass();
        $content->value = "test-value";

        $mockDoc = (new Document())
            ->setContent(Utils::structFromClass($content))
            ->setKey(
                (new Key())
                    ->setId("test-doc")
                    ->setCollection(
                        (new Collection())
                            ->setName("test-col")
                    )
            );

        $mockDoc2 = (new Document())
            ->setContent(Utils::structFromClass($content))
            ->setKey(
                (new Key())
                    ->setId("test-doc2")
                    ->setCollection(
                        (new Collection())
                            ->setName("test-col")
                    )
            );

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                # Reply
                (new DocumentQueryResponse())
                    ->setDocuments([$mockDoc, $mockDoc2]),
                # Status
                $mockStatusObj
            ]);

        $stubGrpcQueueClient = $this->createMock(DocumentServiceClient::class);
        $stubGrpcQueueClient
            ->expects($this->once())
            ->method('Query')
            ->with($this->callback(function (DocumentQueryRequest $request) {
                $this->assertEquals("test-col", $request->getCollection()->getName());
                $this->assertEquals(3, $request->getLimit());
                $this->assertEquals(
                    [
                        (new Expression())
                            ->setOperand("name")
                            ->setOperator("==")
                            ->setValue(
                                (new ExpressionValue())
                                    ->setStringValue("john")
                            )
                    ],
                    Utils::mapRepeatedField($request->getExpressions())
                );
                return true;
            }))
            ->willReturn($stubUnaryCall);

        $content = new stdClass();
        $content->value = "test-value";

        $docs = new Documents(documentClient: $stubGrpcQueueClient);
        $returnedDocs = $docs
            ->collection('test-col')
            ->query()
            ->limit(3)
            ->pageFrom([ "from" => 123])
            ->where("name", "==", "john")
            ->fetch();

        $this->assertEquals(2, count($returnedDocs->getDocuments()));
        $this->assertEquals("test-doc", $returnedDocs->getDocuments()[0]->getRef()->getId());
        $this->assertEquals("test-value", $returnedDocs->getDocuments()[0]->getContent()->value);
        $this->assertEquals("test-doc2", $returnedDocs->getDocuments()[1]->getRef()->getId());
    }
}