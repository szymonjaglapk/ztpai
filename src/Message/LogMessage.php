<?php

namespace App\Message;

class LogMessage
{
    private string $level;
    private string $message;

    public function __construct(string $level, string $message)
    {
        $this->level = $level;
        $this->message = $message;
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}