<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use RabbitMQTraining\Connection\AmqpStreamConnection;
use RabbitMQTraining\IO\ConsoleWriter;
use RabbitMQTraining\PublishSubscribe\LogReceiver;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$host = $_ENV['RABBIT_HOST'];
$port = $_ENV['RABBIT_PORT'];
$username = $_ENV['RABBIT_USERNAME'];
$password = $_ENV['RABBIT_PASSWORD'];

$connection = new AMQPStreamConnection($host, $port, $username, $password);
$logReceiver = new LogReceiver(new ConsoleWriter(), $connection->channel());
$logReceiver->consume();
