<?php

declare(strict_types=1);

namespace RabbitMQTests\Unit;

use RabbitMQ\IO\WriterInterface;

final class InMemoryWriter implements WriterInterface
{
    /** @var string[] */
    private array $messages = [];

    public function write(string $message): void
    {
        $this->messages[] = $message;
    }

    public function messages(): array
    {
        return $this->messages;
    }
}
