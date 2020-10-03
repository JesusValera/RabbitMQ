<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use RabbitMQTraining\Connection\AmqpStreamConnection;
use RabbitMQTraining\Connection\StandardUniqueId;
use RabbitMQTraining\IO\ConsoleWriter;
use RabbitMQTraining\Rpc\Client;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$connection = new AmqpStreamConnection(
    $_ENV['RABBIT_HOST'],
    $_ENV['RABBIT_PORT'],
    $_ENV['RABBIT_USERNAME'],
    $_ENV['RABBIT_PASSWORD']
);

$data = (int) implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = 30;
}

$client = new Client(new ConsoleWriter(), $connection->channel(), new StandardUniqueId());
$client->publish($data);
