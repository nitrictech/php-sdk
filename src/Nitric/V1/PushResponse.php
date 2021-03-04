<?php

namespace Nitric\V1;

class PushResponse
{

    private array $failedEvents;

    /**
     * @return FailedEvent[]
     */
    public function getFailedEvents(): array
    {
        return $this->failedEvents;
    }

    /**
     * @param FailedEvent[] $failedEvents
     */
    public function setFailedEvents(FailedEvent...$failedEvents): void
    {
        $this->failedEvents = $failedEvents;
    }

    public function __construct(FailedEvent...$failedEvents)
    {
        $this->failedEvents = $failedEvents;
    }


}