<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit;

use RabbitMQTraining\IO\WriterInterface;

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
