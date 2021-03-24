<?php

namespace Nitric\Api;

class FailedTask
{
    private Task|null $task;

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }

    /**
     * @param Task $task
     */
    public function setTask(Task $task): void
    {
        $this->task = $task;
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

    public function __construct(Task $task = null, string $message = null)
    {
        $this->task = $task;
        $this->message = $message;
    }
}