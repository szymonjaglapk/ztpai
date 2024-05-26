<?php

namespace App\Service;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use App\Message\LogMessage;

class LoggerService
{
    private ProducerInterface $producer;

    public function __construct(ProducerInterface $loggerProducer)
    {
        $this->producer = $loggerProducer;
    }

    public function log(string $level, string $message): void
    {
        $logMessage = new LogMessage($level, $message);
        $this->producer->publish(serialize($logMessage));
    }
}