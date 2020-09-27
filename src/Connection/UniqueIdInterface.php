<?php

declare(strict_types=1);

namespace RabbitMQTraining\Connection;

interface UniqueIdInterface
{
    public function generate(): string;
}
