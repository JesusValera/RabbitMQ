<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use RabbitMQ\Connection\AMQPStreamConnection;
use RabbitMQ\HelloWorld\Sender;
use RabbitMQ\IO\ConsoleWriter;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$connection = new AMQPStreamConnection(
    $_ENV['RABBIT_HOST'],
    $_ENV['RABBIT_PORT'],
    $_ENV['RABBIT_USERNAME'],
    $_ENV['RABBIT_PASSWORD']
);

$sender = new Sender(new ConsoleWriter(), $connection->channel());
$sender->publish();
