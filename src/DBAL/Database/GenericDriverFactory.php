<?php

namespace Nulldark\DBAL\Database;

use Nulldark\DBAL\Database\MySQL\MySQLDriver;
use Nulldark\DBAL\Database\Postgres\PostgresDriver;
use Nulldark\DBAL\Database\SQLite\SQLiteDriver;
use Nulldark\DBAL\Exception\UnsupportedDriverException;

/**
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Database
 * @license LGPL-2.1
 * @version 0.5.0
 *
 * @phpstan-import-type ConnectionParams from \Nulldark\DBAL\ConnectionManager
 *
 */
final class GenericDriverFactory
{
    /**
     * @param ConnectionParams $params
     * @return GenericDriverInterface
     *
     * @throws UnsupportedDriverException
     */
    public function createDriver(#[\SensitiveParameter] array $params): GenericDriverInterface
    {
        return match ($params['driver']) {
            'mysql' => new MySQLDriver($params),
            'pqsql' => new PostgresDriver($params),
            'sqlite' => new SQLiteDriver($params),
            default => throw new UnsupportedDriverException("The given driver '{$params['driver']}' is unknown.")
        };
    }
}
