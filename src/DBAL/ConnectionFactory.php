<?php

namespace Nulldark\DBAL;

use Nulldark\DBAL\Exception\MissingDriverException;
use Nulldark\DBAL\Exception\UnsupportedDriverException;

final class ConnectionFactory
{
    /**
     * @param array $params
     * @param array $configuration
     * @return Connection
     * @throws UnsupportedDriverException
     */
    public static function createConnection(
        #[\SensitiveParameter]
        array $params,
        array $configuration = []
    ): Connection
    {
        $driver = self::createDrive($params['driver'] ?: null);

        return new Connection(
            $params,
            $configuration,
            $driver
        );

    }

    /**
     * @param string|null $driver
     * @return \Nulldark\DBAL\Driver\Driver
     * @throws MissingDriverException
     * @throws UnsupportedDriverException
     */
    private static function createDrive(?string $driver): \Nulldark\DBAL\Driver\Driver
    {
        if ($driver === null) {
            throw new MissingDriverException('The options "driver" are mandatory.');
        }

        return match ($driver) {
            'pdo_mysql' => new Driver\PDO\MySQL\Driver(),
            default => throw new UnsupportedDriverException($driver)
        };
    }
}