<?php

declare(strict_types=1);

namespace RabbitMQTraining\Connection;

final class StandardUniqueId implements UniqueIdInterface
{
    public function generate(): string
    {
        return uniqid();
    }
}
