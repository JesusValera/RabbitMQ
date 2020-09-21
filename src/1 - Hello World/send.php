<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\AmqpStreamConnection;
use RabbitMQTraining\HelloWorld\Sender;
use RabbitMQTraining\IO\ConsoleWriter;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$connection = new AmqpStreamConnection(
    $_ENV['RABBIT_HOST'],
    $_ENV['RABBIT_PORT'],
    $_ENV['RABBIT_USERNAME'],
    $_ENV['RABBIT_PASSWORD']
);

$sender = new Sender(new ConsoleWriter(), $connection->channel());
$sender->publish(new AMQPMessage('Hello World!'));
