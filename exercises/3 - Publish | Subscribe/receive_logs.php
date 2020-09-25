<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use RabbitMQTraining\Connection\AmqpStreamConnection;
use RabbitMQTraining\IO\ConsoleWriter;
use RabbitMQTraining\PublishSubscribe\LogReceiver;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$connection = new AmqpStreamConnection(
    $_ENV['RABBIT_HOST'],
    $_ENV['RABBIT_PORT'],
    $_ENV['RABBIT_USERNAME'],
    $_ENV['RABBIT_PASSWORD']
);

$receiver = new LogReceiver(new ConsoleWriter(), $connection->channel());
$receiver->consume();
