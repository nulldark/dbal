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

use SensitiveParameter;

/**
 * @internal
 *
 * @author Dominik Szamburski
 * @package Nulldark\DBAL
 * @license LGPL-2.1
 *
 * @phpstan-type ConnectionParams = array{
 *   "driver": string,
 *   "database"?: string,
 *   "username"?: string,
 *   "password"?: string,
 *   "host"?: string,
 *   "port"?: int,
 *   "charset"?: string
 *  }
 */
final class DriverParams
{
    /**
     * The connection params.
     *
     * @var ConnectionParams $params
     */
    private array $params;

    /**
     * The driver class.
     *
     * @var Driver|null $driver
     */
    private ?Driver $driver;

    /**
     * @param ConnectionParams $params
     */
    public function __construct(#[SensitiveParameter] array $params)
    {
        $this->params = $params;
        $this->driver = Driver::from($params['driver']);
    }

    /**
     * Returns a host used to connect to the database.
     *
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->params['host'] ?? null;
    }

    /**
     * Returns a port used to connect to the database.
     *
     * @return int|null
     */
    public function getPort(): ?int
    {
        return $this->params['port'] ?? null;
    }

    /**
     * Returns a database name.
     *
     * @return string|null
     */
    public function getDatabase(): ?string
    {
        return $this->params['database'] ?? null;
    }

    /**
     * Returns a username used to connect to the database.
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->params['username'] ?? null;
    }

    /**
     * Returns a charset.
     *
     * @return string|null
     */
    public function getCharset(): ?string
    {
        return $this->params['charset'] ?? null;
    }

    /**
     * Returns a password used to connect to the database.
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->params['password'] ?? null;
    }

    /**
     * Returns a PDO Options.
     *
     * @return array<int, int|string|bool>
     */
    public function getOptions(): array
    {
        return $this->params['options'] ?? [];
    }

    public function dsn(): string
    {
        $dsn = "{$this->driver->name}:";

        if ($this->driver === Driver::SQLITE) {
            $dsn .= $this->getDatabase();
        } else {
            if (isset($this->params['host'])) {
                $dsn .= "host={$this->getHost()};";
            }

            if (isset($this->params['port'])) {
                $dsn .= "port={$this->getPort()};";
            }

            if (isset($this->params['database'])) {
                $dsn .= "dbname={$this->getDatabase()}";
            }

            if (isset($this->params['charset'])) {
                $dsn .= "charset={$this->getCharset()}";
            }
        }

        return $dsn;
    }
}
