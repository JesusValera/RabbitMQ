<?php

declare(strict_types=1);

namespace RabbitMQ\IO;

final class ConsoleWriter implements WriterInterface
{
    public function write($message): void
    {
        echo $message;
    }
}
