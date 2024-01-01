<?php

/**
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This file is part of abyss/dbal
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

namespace Abyss\DBAL\Query;

use InvalidArgumentException;
use Abyss\DBAL\FetchMode;
use Abyss\Stdlib\Collections\CollectionInterface;

/**
 * SQL Query Builder with fluid interface SQL.
 *
 * @author Dominik Szamburski
 * @package Abyss\DBAL\Query
 * @license LGPL-2.1
 * @since 0.3.0
 */
interface QueryBuilderInterface
{
    /**
     * Set the columns to be selected.
     *
     * @param string ...$columns
     * @return self
     */
    public function select(string ...$columns): self;

    /**
     * Turns the query being built into a INSERT query.
     *
     * @param string $table
     * @return self
     *
     * @since 0.6.0
     */
    public function insert(string $table): self;

    /**
     * Turns the query being built into a UPDATE query.
     *
     * @param string $table
     * @return self
     *
     * @since 0.6.0
     */
    public function update(string $table): self;

    /**
     * Turns the query being built into a DELETE query.
     *
     * @param string $table
     * @return self
     *
     * @since 0.6.0
     */
    public function delete(string $table): self;

    /**
     *
     *
     * @param array<string, mixed> $values
     * @return self
     *
     * @since 0.6.0
     */
    public function values(array $values): self;

    /**
     * Set the table which the query is targeting.
     *
     * @param string $table
     * @param string|null $as
     * @return self
     */
    public function from(string $table, string $as = null): self;

    /**
     * Add where clause to the query.
     *
     * @param string $column
     * @param string $operator
     * @param mixed $values
     * @param string $boolean
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function where(
        string $column,
        string $operator,
        mixed $values,
        string $boolean = 'AND'
    ): self;

    /**
     * Adds ORDER BY clause to the query.
     *
     * @param string $sort
     * @param string|null $order
     *
     * @return self
     */
    public function orderBy(string $sort, ?string $order = null): self;

    /**
     * Adds LIMIT clause to the query.
     *
     * @param int $limit
     * @param int|null $offset
     *
     * @return self
     */
    public function limit(int $limit, ?int $offset = null): self;

    /**
     * Get the SQL representation.
     *
     * @return string
     */
    public function toSQL(): string;

    /**
     * Execute the "SELECT" Query.
     *
     * @param \Abyss\DBAL\FetchMode $fetchMode
     * @return CollectionInterface
     *
     * @deprecated 0.7.0
     */
    public function get(FetchMode $fetchMode = FetchMode::OBJECT): CollectionInterface;
}
