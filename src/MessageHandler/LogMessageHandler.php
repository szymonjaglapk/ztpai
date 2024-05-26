<?php

namespace App\MessageHandler;

use App\Message\LogMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class LogMessageHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(LogMessage $message): void
    {
        $level = $message->getLevel();
        $logMessage = $message->getMessage();
        $this->logger->$level($logMessage);
    }
}