<?php

namespace Nulldark\DBAL;

use Nulldark\DBAL\Driver\Driver;
use Nulldark\DBAL\Exception\MissingDriverException;
use Nulldark\DBAL\Exception\UnsupportedDriverException;
use SensitiveParameter;

final class ConnectionFactory
{
    /**
     * @param array $params
     * @param array $configuration
     * @return Connection
     * @throws UnsupportedDriverException
     */
    public static function createConnection(
        #[SensitiveParameter]
        array $params,
        array $configuration = []
    ): Connection {
        $driver = self::createDrive($params['driver'] ?: null);

        return new Connection(
            $params,
            $configuration,
            $driver
        );
    }

    /**
     * @param string|null $driver
     * @return Driver
     * @throws MissingDriverException
     * @throws UnsupportedDriverException
     */
    private static function createDrive(?string $driver): Driver
    {
        if ($driver === null) {
            throw new MissingDriverException('The options "driver" are mandatory.');
        }

        return match ($driver) {
            'pdo_mysql' => new \Nulldark\DBAL\Driver\PDO\MySQL\Driver(),
            default => throw new UnsupportedDriverException($driver)
        };
    }
}
