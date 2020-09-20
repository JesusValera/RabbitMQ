<?php

declare(strict_types=1);

namespace RabbitMQTraining\IO;

final class ConsoleWriter implements WriterInterface
{
    public function write(string $message): void
    {
        echo $message;
    }
}
