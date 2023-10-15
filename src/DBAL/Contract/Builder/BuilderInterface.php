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

namespace Nulldark\DBAL\Contract\Builder;

use InvalidArgumentException;
use Nulldark\Collection\CollectionInterface;

/**
 * SQL Query Builder with fluid interface SQL.
 *
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Contract\Builder
 * @license LGPL-2.1
 * @version 0.3.0
 */
interface BuilderInterface
{
    /**
     * Set the columns to be selected.
     *
     * @param string ...$columns
     * @return self
     */
    public function select(string ...$columns): self;

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
        mixed$values,
        string $boolean = 'AND'
    ): self;

    /**
     * Get the SQL representation.
     *
     * @return string
     */
    public function toSQL(): string;

    /**
     * Execute the "SELECT" Query.
     *
     * @return CollectionInterface
     */
    public function get(): CollectionInterface;
}
