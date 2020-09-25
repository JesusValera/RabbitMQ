<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\AmqpStreamConnection;
use RabbitMQTraining\IO\ConsoleWriter;
use RabbitMQTraining\Routing\LogEmitterDirect;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$connection = new AmqpStreamConnection(
    $_ENV['RABBIT_HOST'],
    $_ENV['RABBIT_PORT'],
    $_ENV['RABBIT_USERNAME'],
    $_ENV['RABBIT_PASSWORD']
);

$emitter = new LogEmitterDirect(new ConsoleWriter(), $connection->channel());

$severity = !empty($argv[1]) ? $argv[1] : 'info';
$data = implode(' ', array_slice($argv, 2));
if (empty($data)) {
    $data = 'Hello World!';
}
$emitter->publish($severity, new AMQPMessage($data));
