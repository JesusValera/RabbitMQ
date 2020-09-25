<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\Routing;

use PHPUnit\Framework\TestCase;
use RabbitMQTraining\Connection\EmptyChannel;
use RabbitMQTraining\Routing\LogReceiverDirect;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

final class LogReceiverDirectTest extends TestCase
{
    /** @test */
    public function publish(): void
    {
        $writer = new InMemoryWriter();
        $logReceiver = new LogReceiverDirect($writer, new EmptyChannel());
        $logReceiver->consume(['info', 'warning']);
        self::assertSame(
            [
                " [x] Waiting for logs. To exit press Ctrl+C\n",
                " [x] routingKey: basicConsume callback\n",
            ],
            $writer->messages()
        );
    }
}
