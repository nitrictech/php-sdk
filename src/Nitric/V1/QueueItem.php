<?php

namespace Nitric\V1;

class QueueItem
{
    private Event $event;
    private string $leaseID;

    public function __construct(Event $event, string $leaseID)
    {
        $this->event = $event;
        $this->leaseID = $leaseID;
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getLeaseID(): string
    {
        return $this->leaseID;
    }

    /**
     * @param string $leaseID
     */
    public function setLeaseID(string $leaseID): void
    {
        $this->leaseID = $leaseID;
    }
}