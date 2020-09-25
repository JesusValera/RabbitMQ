<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\Topics;

use PHPUnit\Framework\TestCase;
use RabbitMQTraining\Connection\EmptyChannel;
use RabbitMQTraining\Topics\LogReceiverTopics;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

final class LogReceiverTopicsTest extends TestCase
{
    /** @test */
    public function consume(): void
    {
        $writer = new InMemoryWriter();
        $logReceiver = new LogReceiverTopics($writer, new EmptyChannel());
        $logReceiver->consume(['*.critical', '#']);
        self::assertSame(
            [
                " [x] Waiting for logs. To exit press Ctrl+C\n",
                " [x] routingKey: basicConsume callback\n",
            ],
            $writer->messages()
        );
    }
}
