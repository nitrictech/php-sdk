<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: secret/v1/secret.proto

namespace GPBMetadata\Secret\V1;

class Secret
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
secret/v1/secret.protonitric.secret.v1"K
SecretPutRequest(
secret (2.nitric.secret.v1.Secret
value ("L
SecretPutResponse7
secret_version (2.nitric.secret.v1.SecretVersion"N
SecretAccessRequest7
secret_version (2.nitric.secret.v1.SecretVersion"^
SecretAccessResponse7
secret_version (2.nitric.secret.v1.SecretVersion
value ("
Secret
name (	"J
SecretVersion(
secret (2.nitric.secret.v1.Secret
version (	2�
SecretServiceN
Put".nitric.secret.v1.SecretPutRequest#.nitric.secret.v1.SecretPutResponseW
Access%.nitric.secret.v1.SecretAccessRequest&.nitric.secret.v1.SecretAccessResponseBf
io.nitric.proto.secret.v1BSecretsPZnitric/v1;v1�Nitric.Proto.Secret.v1�Nitric\\Proto\\Secret\\V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

