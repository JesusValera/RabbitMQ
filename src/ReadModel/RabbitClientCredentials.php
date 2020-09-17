<?php

declare(strict_types=1);

namespace RabbitMQ\ReadModel;

final class RabbitClientCredentials
{
    public string $host;
    public string $port;
    public string $username;
    public string $password;

    private function __construct(string $host, string $port, string $username, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    public static function withEnvParams(array $env): self
    {
        return new self(
            $env['RABBIT_HOST'],
            $env['RABBIT_PORT'],
            $env['RABBIT_USERNAME'],
            $env['RABBIT_PASSWORD']
        );
    }
}
