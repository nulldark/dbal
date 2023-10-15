<?php

namespace Nulldark\DBAL;

use Nulldark\DBAL\Database\MySQL\MySQLDriver;
use Nulldark\DBAL\Database\Postgres\PostgresDriver;
use Nulldark\DBAL\Database\SQLite\SQLiteDriver;

/**
 * @author Dominik Szamburski
 * @package Nulldark\DBAL
 * @license LGPL-2.1
 * @since 0.4.0
 */
enum Driver: string
{
    case MYSQL = 'mysql';
    case POSTGRES = 'postgres';
    case SQLITE = 'sqlite';

    /**
     * Gets a driver class impl.
     *
     * @return string
     */
    public function driverClass(): string
    {
        return match ($this) {
            Driver::MYSQL => MySQLDriver::class,
            Driver::POSTGRES => PostgresDriver::class,
            Driver::SQLITE => SQLiteDriver::class
        };
    }
}
