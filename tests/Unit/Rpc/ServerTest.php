<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\Rpc;

use PHPUnit\Framework\TestCase;
use RabbitMQTraining\Connection\EmptyChannel;
use RabbitMQTraining\Rpc\Server;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

final class ServerTest extends TestCase
{
    /** @test */
    public function consume(): void
    {
        $writer = new InMemoryWriter();
        $client = new Server($writer, new EmptyChannel());
        $client->consume();

        self::assertSame(
            [
                " [x] Awaiting RPC requests\n",
                " [.] fib(0)\n"
            ],
            $writer->messages()
        );
    }
}
