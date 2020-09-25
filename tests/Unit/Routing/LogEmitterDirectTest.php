<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\Routing;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\EmptyChannel;
use RabbitMQTraining\Routing\LogEmitterDirect;
use PHPUnit\Framework\TestCase;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

final class LogEmitterDirectTest extends TestCase
{
    /** @test */
    public function publish(): void
    {
        $writer = new InMemoryWriter();
        $logEmitter = new LogEmitterDirect($writer, new EmptyChannel());
        $logEmitter->publish('info', new AMQPMessage('body message'));
        self::assertSame([" [x] Sent info: body message\n"], $writer->messages());
    }
}
