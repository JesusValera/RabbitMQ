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

echo " [x] Waiting for messages. To exit press Ctrl+C\n";

$callback = static function ($message): void {
    echo ' [x] Received ', $message->body, "\n";
};

$channel->basic_consume('hello', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
