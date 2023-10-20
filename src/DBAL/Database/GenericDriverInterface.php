<?php

/**
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This file is part of nulldark/dbal
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace Nulldark\DBAL\Database;

use Nulldark\DBAL\Statement;
use PDO;
use PDOStatement;

/**
 * Wraps PDO connection and provides common databases API.
 *
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Database
 * @license LGPL-2.1
 * @since 0.5.0
 */
interface GenericDriverInterface
{
    /**
     * Attempts to create a connection with the database.
     *
     * @return PDO
     */
    public function connect(): PDO;

    /**
     * Prepares an SQL statement.
     *
     * @param string $query
     * @return PDOStatement
     */
    public function prepare(string $query): PDOStatement;

    /**
     * Executes an SQL query.
     *
     * @param string $query
     * @return PDOStatement
     */
    public function query(string $query): PDOStatement;

    /**
     * Start SQL transaction with specified isolation level.
     *
     * @param string|null $isolationLevel
     * @return bool True of success.
     */
    public function beginTransaction(string $isolationLevel = null): bool;

    /**
     * Commit the active transaction.
     *
     * @return bool True of success.
     */
    public function commit(): bool;

    /**
     * Rollback the active transaction.
     *
     * @return bool True of success.
     */
    public function rollback(): bool;

    /**
     * Returns a database platform.
     *
     * @return AbstractPlatform
     */
    public function getDatabasePlatform(): AbstractPlatform;
}
