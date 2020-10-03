<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\HelloWorld;

use PHPUnit\Framework\TestCase;
use RabbitMQTraining\Connection\EmptyChannel;
use RabbitMQTraining\HelloWorld\Receiver;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

final class ReceiverTest extends TestCase
{
    /** @test */
    public function consume(): void
    {
        $writer = new InMemoryWriter();
        $receiver = new Receiver($writer, new EmptyChannel());
        $receiver->consume();

        self::assertSame(
            [
                " [x] Waiting for messages. To exit press Ctrl+C\n",
                " [x] Received basicConsume callback\n",
            ],
            $writer->messages()
        );
    }
}
