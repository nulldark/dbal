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

use Closure;
use Nulldark\DBAL\Query\QueryBuilder;
use Nulldark\DBAL\Database\GenericDriverInterface;

/**
 * Connection class is a High Level of abstraction at top of Driver.
 *
 * @author Dominik Szamburski
 * @package Nulldark\DBAL
 * @license LGPL-2.1
 * @version 0.3.0
 */
class Connection implements ConnectionInterface
{
    public function __construct(
        protected string $name,
        protected GenericDriverInterface $driver,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function prepare(string $query): Statement
    {
        return new Statement(
            $this->driver->prepare($query)
        );
    }

    /**
     * @inheritDoc
     */
    public function query(string $query, array $parameters = []): Result
    {
        $stmt = $this->driver->query($query);
        $stmt->execute();

        return new Result(
            $stmt
        );
    }

    /**
     * @inheritDoc
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this);
    }

    /**
     * @inheritDoc
     */
    public function beginTransaction(string $isolationLevel = null): bool
    {
        return $this->driver->beginTransaction($isolationLevel);
    }

    /**
     * @inheritDoc
     */
    public function commit(): bool
    {
        return $this->driver->commit();
    }

    /**
     * @inheritDoc
     */
    public function rollback(): bool
    {
        return $this->driver->rollback();
    }

    /**
     * @inheritDoc
     */
    public function transaction(Closure $closure): mixed
    {
        $this->beginTransaction();

        try {
            $result = $closure($this);
            $this->commit();

            return $result;
        } catch (\Throwable $e) {
            $this->rollback();
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function getDriver(): GenericDriverInterface
    {
        return $this->driver;
    }
}
