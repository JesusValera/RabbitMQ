<?php

declare(strict_types=1);

namespace RabbitMQ\IO;

interface WriterInterface
{
    public function write($message): void;
}
