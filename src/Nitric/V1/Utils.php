<?php


namespace Nitric\V1;

use \Exception;
use \stdClass;
use Google\Protobuf\Struct;

class Utils
{
    static function structFromClass(stdClass $obj): Struct
    {
        $struct = new Struct();
        try {
            $struct->mergeFromJsonString(json_encode($obj));
        } catch (Exception $e) {
           throw new Exception("Failed to serialize object. Details: " . $e->getMessage());
        }
        return $struct;
    }

    static function classFromStruct(Struct $struct): stdClass|null
    {
        if($struct == null) {
            return null;
        }
        try {
            return json_decode($struct->serializeToJsonString());
        } catch (Exception $e) {
            throw new Exception("Failed to deserialize struct. Details: " . $e->getMessage());
        }
    }
}