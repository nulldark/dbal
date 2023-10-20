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

namespace Nulldark\DBAL;

use Nulldark\DBAL\Builder\BuilderInterface;

/**
 * Connection is High Level of abstraction used to represent single Database.
 *
 * @author Dominik Szamburski
 * @package Nulldark\DBAL
 * @license LGPL-2.1
 * @since 0.5.0
 */
interface ConnectionInterface
{
    /**
     * Prepares an SQL statement.
     *
     * @param string $query
     *
     * @return Statement
     */
    public function prepare(string $query): Statement;

    /**
     * Executes an, optionally parameterized, SQL query.
     *
     * @param string                            $query
     * @param list<mixed>|array<string, mixed>  $parameters
     *
     * @return Result
     */
    public function query(string $query, array $parameters = []): Result;

    /**
     * Starts database transaction.
     *
     * @param string|null $isolationLevel
     * @return bool
     */
    public function beginTransaction(string $isolationLevel = null): bool;

    /**
     * Commit the active transaction.
     *
     * @return bool
     */
    public function commit(): bool;

    /**
     * Rollback the active transaction.
     *
     * @return bool
     */
    public function rollback(): bool;

    /**
     * Gets a new QueryBuilder instance.
     *
     * @return \Nulldark\DBAL\Builder\BuilderInterface
     */
    public function getQueryBuilder(): BuilderInterface;
}
