<?php

declare(strict_types=1);

namespace RabbitMQTests\Unit;

use RabbitMQ\IO\WriterInterface;

final class Writer implements WriterInterface
{
    public array $messages = [];

    public function write($message): void
    {
        $this->messages[] = $message;
    }
}
