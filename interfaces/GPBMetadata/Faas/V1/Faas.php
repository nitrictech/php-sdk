<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: faas/v1/faas.proto

namespace GPBMetadata\Faas\V1;

class Faas
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
faas/v1/faas.protonitric.faas.v1"�
ClientMessage

id (	3
init_request (2.nitric.faas.v1.InitRequestH ;
trigger_response (2.nitric.faas.v1.TriggerResponseH B	
content"�
ServerMessage

id (	5
init_response (2.nitric.faas.v1.InitResponseH 9
trigger_request (2.nitric.faas.v1.TriggerRequestH B	
content"
InitRequest"
InitResponse"�
TriggerRequest
data (
	mime_type (	2
http (2".nitric.faas.v1.HttpTriggerContextH 4
topic (2#.nitric.faas.v1.TopicTriggerContextH B	
context"�
HttpTriggerContext
method (	
path (	@
headers (2/.nitric.faas.v1.HttpTriggerContext.HeadersEntryI
query_params (23.nitric.faas.v1.HttpTriggerContext.QueryParamsEntry.
HeadersEntry
key (	
value (	:82
QueryParamsEntry
key (	
value (	:8"$
TopicTriggerContext
topic (	"�
TriggerResponse
data (3
http
 (2#.nitric.faas.v1.HttpResponseContextH 5
topic (2$.nitric.faas.v1.TopicResponseContextH B	
context"�
HttpResponseContextA
headers (20.nitric.faas.v1.HttpResponseContext.HeadersEntry
status (.
HeadersEntry
key (	
value (	:8"\'
TopicResponseContext
success (2`
FaasServiceQ
TriggerStream.nitric.faas.v1.ClientMessage.nitric.faas.v1.ServerMessage(0Bc
io.nitric.proto.faas.v1B
NitricFaasPZnitric/v1;v1�Nitric.Proto.Faas.v1�Nitric\\Proto\\Faas\\V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

