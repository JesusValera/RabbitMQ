<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\Rpc;

use PHPUnit\Framework\TestCase;
use RabbitMQTraining\Connection\EmptyChannel;
use RabbitMQTraining\Rpc\Client;
use RabbitMQTrainingTests\Unit\FakeUniqueId;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

final class ClientTest extends TestCase
{
    /** @test */
    public function publish(): void
    {
        $writer = new InMemoryWriter();
        $client = new Client($writer, new EmptyChannel(), new FakeUniqueId());
        $client->publish(5);

        self::assertSame([" [.] Got basicConsume callback\n"], $writer->messages());
    }
}
