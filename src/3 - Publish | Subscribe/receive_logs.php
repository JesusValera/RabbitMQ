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

$connection = new AMQPStreamConnection($host, $port, $username, $password);
$channel = $connection->channel();

$channel->exchange_declare('logs', 'fanout', false, false, false);

[$queueName] = $channel->queue_declare('', false, false, true, false);
$channel->queue_bind($queueName, 'logs');

echo " [x] Waiting for logs. To exit press Ctrl+C\n";

$callback = static function ($message) {
    echo ' [x] Received ', $message->body, "\n";
};

$channel->basic_consume($queueName, '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
