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
use Nulldark\Collection\CollectionInterface;
use Nulldark\DBAL\Builder\Builder;
use Nulldark\DBAL\Contract\Builder\BuilderInterface;
use Nulldark\DBAL\Contract\ConnectionInterface;
use Nulldark\DBAL\Contract\DriverFactoryInterface;
use Nulldark\DBAL\Contract\DriverInterface;

/**
 * @author Dominik Szamburski
 * @package Nulldark\DBAL
 * @license LGPL-2.1
 * @version 0.3.0
 */
class Connection
{
    /** @var DriverInterface $_driver */
    private DriverInterface $_driver;

    /** @var ConnectionInterface|null $connection */
    private ?ConnectionInterface $connection = null;

    /** @var string[] $_params  */
    private array $_params;

    private DriverFactoryInterface $factory;

    /**
     * @param string[] $params
     * @param DriverInterface|null $driver
     */
    public function __construct(
        #[\SensitiveParameter] array $params,
        DriverInterface $driver = null
    ) {
        $this->factory = new DriverFactory();

        if ($driver === null) {
            $driver = $this->factory->createDriver($params);
        }

        $this->_driver = $driver;
        $this->_params = $params;
    }

    /**
     * @return BuilderInterface
     */
    public function query(): BuilderInterface
    {
        return new Builder(
            $this,
        );
    }

    /**
     * @param string $sql
     * @param array<string, string|int|float> $params
     * @return CollectionInterface
     */
    public function select(string $sql, array $params = []): CollectionInterface
    {
        return $this->run($sql, $params, function ($sql, $params) {
            return $this->connection
                ->prepare($sql)
                ->execute($params);
        });
    }

    /**
     * @param string $sql
     * @param array<string, string|int|float> $params
     * @return mixed
     */
    public function first(string $sql, array $params = []): mixed
    {
        return $this->run($sql, $params, function ($sql, $params) {
            return $this->connection
                ->prepare($sql)
                ->execute($params)
                ->first();
        });
    }

    /**
     * @param string $sql
     * @param array<string, string|int|float> $params
     * @param Closure $callback
     * @return mixed
     */
    private function run(string $sql, array $params, Closure $callback): mixed
    {
        if ($this->connection === null) {
            $this->connection = $this->_driver->connect($this->_params);
        }

        return $callback($sql, $params);
    }
}
