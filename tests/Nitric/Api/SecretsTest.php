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
use Nitric\Proto\Secret\V1\Secret;
use Nitric\Proto\Secret\V1\SecretAccessRequest;
use Nitric\Proto\Secret\V1\SecretAccessResponse;
use Nitric\Proto\Secret\V1\SecretPutRequest;
use Nitric\Proto\Secret\V1\SecretPutResponse;
use Nitric\Proto\Secret\V1\SecretServiceClient;
use Nitric\Proto\Secret\V1\SecretVersion;
use Nitric\ProtoUtils\Utils;
use PHPUnit\Framework\TestCase;
use stdClass;
use const Grpc\STATUS_NOT_FOUND;
use const Grpc\STATUS_OK;

/**
 * @covers \Nitric\Api\Documents
 */
class SecretsTest extends TestCase
{
    public function testCreateClient()
    {
        $testClient = $this->createMock(SecretServiceClient::class);
        $documents = new Secrets(secretsClient: $testClient);
        $this->assertEquals($testClient, $documents->_baseSecretClient);
    }

    public function testCreateSecretRef()
    {
        $ref = (new Secrets())->secret("the-secret");
        $this->assertEquals($ref->getName(), "the-secret");
    }

    public function testPutSecret()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $testResponse = new SecretPutResponse();
        $ms = new Secret();
        $ms->setName("the-secret");
        $msv = new SecretVersion();
        $msv->setSecret($ms);
        $msv->setVersion("1");

        $testResponse->setSecretVersion($msv);

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                $testResponse, # Reply
                $mockStatusObj # Status
            ]);

        $testClient = $this->createMock(SecretServiceClient::class);
        $testClient
            ->expects($this->once())
            ->method('Put')
            ->with($this->callback(function (SecretPutRequest $request) {
                $this->assertEquals("the-secret", $request->getSecret()->getName());
                $this->assertEquals("secret-value", $request->getValue());
                return true;
            }))
            ->willReturn($stubUnaryCall);

        $sc = new Secrets(secretsClient: $testClient);

        $ref = $sc->secret("the-secret");
        $sv = $ref->put("secret-value");

        $this->assertEquals($sv->getParent(), $ref);
        $this->assertEquals($sv->getVersion(), "1");
    }

    public function testCreateSecretVersionRef()
    {
        $secRef = (new Secrets())->secret("the-secret");
        $svRef = $secRef->version("test");

        $this->assertEquals($svRef->getParent(), $secRef);
        $this->assertEquals($svRef->getVersion(), "test");
    }

    public function testAccessSecretVersion()
    {
        $mockStatusObj = new stdClass();
        $mockStatusObj->code = STATUS_OK;

        $testResponse = new SecretAccessResponse();
        $ms = new Secret();
        $ms->setName("the-secret");
        $msv = new SecretVersion();
        $msv->setSecret($ms);
        $msv->setVersion("1");
        

        $testResponse->setSecretVersion($msv);
        $testResponse->setValue("secret-value");

        $stubUnaryCall = $this->createMock(UnaryCall::class);
        $stubUnaryCall
            ->expects($this->once())
            ->method('wait')
            ->willReturn([
                $testResponse, # Reply
                $mockStatusObj # Status
            ]);

        $testClient = $this->createMock(SecretServiceClient::class);
        $testClient
            ->expects($this->once())
            ->method('Access')
            ->with($this->callback(function (SecretAccessRequest $request) {
                $this->assertEquals("the-secret", $request->getSecretVersion()->getSecret()->getName());
                $this->assertEquals("latest", $request->getSecretVersion()->getVersion());
                return true;
            }))
            ->willReturn($stubUnaryCall);


        $secRef = (new Secrets(secretsClient: $testClient))->secret("the-secret");
        $svRef = $secRef->latest();

        $secretValue = $svRef->access();

        $this->assertEquals($secretValue->getVersion()->getVersion(), "1");
        $this->assertEquals($secretValue->getVersion()->getParent()->getName(), "the-secret");
        $this->assertEquals($secretValue->value(), "secret-value");
    }
}