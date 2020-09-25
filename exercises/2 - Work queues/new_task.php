<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\AmqpStreamConnection;
use RabbitMQTraining\IO\ConsoleWriter;
use RabbitMQTraining\WorkQueues\NewTask;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$connection = new AmqpStreamConnection(
    $_ENV['RABBIT_HOST'],
    $_ENV['RABBIT_PORT'],
    $_ENV['RABBIT_USERNAME'],
    $_ENV['RABBIT_PASSWORD']
);

$newTask = new NewTask(new ConsoleWriter(), $connection->channel());

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = 'Hello World!';
}
$message = new AMQPMessage($data, [
    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
]);
$newTask->publish($message);
