<?php

namespace Nitric\V1;

class FailedEvent
{
    private Event|null $event;

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
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    private string|null $message;

    public function __construct(Event $event = null, string $message = null)
    {
        $this->event = $event;
        $this->message = $message;
    }
}