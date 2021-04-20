<?php

namespace Nitric\Faas;

abstract class SourceType
{
    public const REQUEST = "REQUEST";
    public const SUBSCRIPTION = "SUBSCRIPTION";
    public const UNKNOWN = "UNKNOWN";

    public static function fromString($sourceType)
    {
        $sourceType = strtoupper($sourceType);
        return match ($sourceType) {
            self::REQUEST => self::REQUEST,
            self::SUBSCRIPTION => self::SUBSCRIPTION,
            default => self::UNKNOWN,
        };
    }
}
