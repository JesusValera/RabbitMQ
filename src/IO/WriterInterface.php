<?php

declare(strict_types=1);

namespace RabbitMQTraining\IO;

interface WriterInterface
{
    public function write(string $message): void;
}
