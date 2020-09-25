<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use RabbitMQTraining\Connection\AmqpStreamConnection;
use RabbitMQTraining\IO\ConsoleWriter;
use RabbitMQTraining\Routing\LogReceiverDirect;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$connection = new AmqpStreamConnection(
    $_ENV['RABBIT_HOST'],
    $_ENV['RABBIT_PORT'],
    $_ENV['RABBIT_USERNAME'],
    $_ENV['RABBIT_PASSWORD']
);

$receiver = new LogReceiverDirect(new ConsoleWriter(), $connection->channel());

$severities = array_slice($argv, 1);
if (empty($severities)) {
    file_put_contents('php://stderr', "Usage: $argv[0] [info] [warning] [error]\n");
    exit(1);
}
$receiver->consume($severities);
