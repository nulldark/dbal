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

use Nulldark\DBAL\Contract\CapsuleInterface;
use Nulldark\DBAL\Contract\ConnectionInterface;
use Nulldark\DBAL\Contract\DriverFactoryInterface;
use Nulldark\DBAL\Database\InMemory\InMemoryConnection;
use Nulldark\DBAL\Database\MySQL\MySQLConnection;
use Nulldark\DBAL\Database\Postgres\PostgresConnection;

/**
 * @author Dominik Szamburski
 * @package DBAL
 * @license LGPL-2.1
 * @version 0.3.0
 */
class Capsule implements CapsuleInterface
{
    /** @var DriverFactoryInterface $factory */
    private DriverFactoryInterface $factory;

    public function __construct(DriverFactoryInterface $factory = null)
    {
        $this->factory = $factory ?: new DriverFactory();
    }

    /**
     * @inheritDoc
     */
    public function createConnection(#[\SensitiveParameter] array $parameters): ConnectionInterface
    {
        $driver = $this->factory->createDriver($parameters);

        $connection = match ($parameters['driver']) {
            'inmemory' => new InMemoryConnection(),
            'pgsql' => new PostgresConnection(),
            'mysql' => new MySQLConnection()
        };

        $connection->setDriver($driver);

        return $connection;
    }

    /**
     * Get a driver factory.
     *
     * @return DriverFactoryInterface
     */
    public function getDriverFactory(): DriverFactoryInterface
    {
        return $this->factory;
    }
}
