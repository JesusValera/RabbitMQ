<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$host = $_ENV['RABBIT_HOST'];
$port = $_ENV['RABBIT_PORT'];
$username = $_ENV['RABBIT_USERNAME'];
$password = $_ENV['RABBIT_PASSWORD'];

$connection = new AMQPStreamConnection($host, $port, $username, $password);
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$message = new AMQPMessage('Hello World!');
$channel->basic_publish($message, '', 'hello');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();
