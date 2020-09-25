<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\PublishSubscribe;

use PHPUnit\Framework\TestCase;
use RabbitMQTraining\Connection\EmptyChannel;
use RabbitMQTraining\PublishSubscribe\LogReceiver;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

final class LogReceiverTest extends TestCase
{
    /** @test */
    public function consume(): void
    {
        $writer = new InMemoryWriter();
        $logReceiver = new LogReceiver($writer, new EmptyChannel());
        $logReceiver->consume();
        self::assertSame(
            [
                " [x] Waiting for logs. To exit press Ctrl+C\n",
                " [x] Received basicConsume callback\n",
            ],
            $writer->messages()
        );
    }
}
