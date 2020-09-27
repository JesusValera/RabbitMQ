<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit;

use RabbitMQTraining\Connection\UniqueIdInterface;

final class FakeUniqueId implements UniqueIdInterface
{
    public function generate(): string
    {
        return '1';
    }
}
