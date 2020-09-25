<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\PublishSubscribe\LogEmitter;
use RabbitMQTraining\Connection\AmqpStreamConnection;
use RabbitMQTraining\IO\ConsoleWriter;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$connection = new AmqpStreamConnection(
    $_ENV['RABBIT_HOST'],
    $_ENV['RABBIT_PORT'],
    $_ENV['RABBIT_USERNAME'],
    $_ENV['RABBIT_PASSWORD']
);

$emitter = new LogEmitter(new ConsoleWriter(), $connection->channel());

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = 'info: Hello World!';
}
$emitter->publish(new AMQPMessage($data));
