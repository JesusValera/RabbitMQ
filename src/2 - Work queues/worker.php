<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$host = $_ENV['RABBIT_HOST'];
$port = $_ENV['RABBIT_PORT'];
$username = $_ENV['RABBIT_USERNAME'];
$password = $_ENV['RABBIT_PASSWORD'];

$connection = new AMQPStreamConnection($host, $port, $username, $password);
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, $durable = true, false, false);

echo " [x] Waiting for messages. To exit press Ctrl+C\n";

$callback = static function ($message) {
    echo ' [x] Received ', $message->body, "\n";
    sleep(substr_count($message->body, '.'));
    echo " [x] Done\n";

    /** @var AMQPChannel $channel */
    $channel = $message->delivery_info['channel'];
    $channel->basic_ack($message->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, $no_ack = false, false, false, $callback);
while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
