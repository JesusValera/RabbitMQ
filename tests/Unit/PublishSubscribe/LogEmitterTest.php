<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\PublishSubscribe;

use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;
use RabbitMQTraining\Connection\EmptyChannel;
use RabbitMQTraining\PublishSubscribe\LogEmitter;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

final class LogEmitterTest extends TestCase
{
    /** @test */
    public function publish(): void
    {
        $writer = new InMemoryWriter();
        $logEmitter = new LogEmitter($writer, new EmptyChannel());
        $logEmitter->publish(new AMQPMessage('body message'));
        self::assertSame([" [x] Sent body message\n"], $writer->messages());
    }
}
