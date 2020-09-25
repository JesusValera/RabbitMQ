<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\Topics;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\EmptyChannel;
use PHPUnit\Framework\TestCase;
use RabbitMQTraining\Topics\LogEmitterTopics;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

final class LogEmitterTopicsTest extends TestCase
{
    /** @test */
    public function publish(): void
    {
        $writer = new InMemoryWriter();
        $logEmitter = new LogEmitterTopics($writer, new EmptyChannel());
        $logEmitter->publish('*.critical', new AMQPMessage('body message'));
        self::assertSame([" [x] Sent *.critical: body message\n"], $writer->messages());
    }
}
