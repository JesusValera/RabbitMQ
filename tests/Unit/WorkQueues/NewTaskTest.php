<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\WorkQueues;

use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;
use RabbitMQTraining\Connection\EmptyChannel;
use RabbitMQTraining\WorkQueues\NewTask;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

final class NewTaskTest extends TestCase
{
    /** @test */
    public function publish(): void
    {
        $writer = new InMemoryWriter();
        $newTask = new NewTask($writer, new EmptyChannel());
        $newTask->publish(new AMQPMessage('body message'));

        self::assertSame(
            ["[x] Sent body message\n"],
            $writer->messages()
        );
    }
}
