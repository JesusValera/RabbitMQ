<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use PhpAmqpLib\Connection\AMQPStreamConnection;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$host = $_ENV['RABBIT_HOST'];
$port = $_ENV['RABBIT_PORT'];
$username = $_ENV['RABBIT_USERNAME'];
$password = $_ENV['RABBIT_PASSWORD'];

$connection = new \RabbitMQTraining\Connection\AmqpStreamConnection($host, $port, $username, $password);

$worker = new \RabbitMQTraining\WorkQueues\Worker(new \RabbitMQTraining\IO\ConsoleWriter(), $connection->channel());
$worker->consume();
