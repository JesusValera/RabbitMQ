<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\WorkQueues;

use PHPUnit\Framework\TestCase;
use RabbitMQTraining\Connection\EmptyChannel;
use RabbitMQTraining\WorkQueues\Worker;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

final class WorkerTest extends TestCase
{
    /** @test */
    public function consume(): void
    {
        $writer = new InMemoryWriter();
        $newTask = new Worker($writer, new EmptyChannel());
        $newTask->consume();

        self::assertSame(
            [
                " [x] Waiting for messages. To exit press Ctrl+C\n",
                " [x] Received basicConsume callback\n",
                " [x] Done\n",
            ],
            $writer->messages()
        );
    }
}
