<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: event/v1/event.proto

namespace GPBMetadata\Event\V1;

class Event
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Protobuf\Struct::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
event/v1/event.protonitric.event.v1"Q
EventPublishRequest
topic (	+
event (2.nitric.event.v1.NitricEvent""
EventPublishResponse

id (	"
TopicListRequest"A
TopicListResponse,
topics (2.nitric.event.v1.NitricTopic"
NitricTopic
name (	"Y
NitricEvent

id (	
payload_type (	(
payload (2.google.protobuf.Struct2f
EventServiceV
Publish$.nitric.event.v1.EventPublishRequest%.nitric.event.v1.EventPublishResponse2]
TopicServiceM
List!.nitric.event.v1.TopicListRequest".nitric.event.v1.TopicListResponseBb
io.nitric.proto.event.v1BEventsPZnitric/v1;v1�Nitric.Proto.Event.v1�Nitric\\Proto\\Event\\V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

