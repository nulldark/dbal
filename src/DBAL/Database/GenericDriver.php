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

use PDO;
use PDOStatement;

/**
 * Provides a Low Level abstraction at top of databases platform.
 *
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Database
 * @license LGPL-2.1
 * @since 0.5.0
 *
 * @phpstan-import-type ConnectionParams from \Nulldark\DBAL\ConnectionManager
 */
abstract class GenericDriver implements GenericDriverInterface
{
    protected ?PDO $pdo = null;

    /**
     * @param ConnectionParams $params
     */
    public function __construct(
        #[\SensitiveParameter] protected array $params
    ) {
    }

    /**
     * @inheritDoc
     */
    public function query(string $query): PDOStatement
    {
        $stmt = $this->getPDO()->query($query);
        assert($stmt instanceof PDOStatement);

        return $stmt;
    }

    /**
     * @inheritDoc
     */
    public function prepare(string $query): PDOStatement
    {
        $stmt = $this->getPDO()->prepare($query);
        assert($stmt instanceof PDOStatement);

        return $stmt;
    }

    /**
     * @inheritDoc
     */
    public function connect(): PDO
    {
        $options = $this->params['options'] ?? [];

        if (!empty($this->params['persistent'])) {
            $options[PDO::ATTR_PERSISTENT] = true;
        }

        return new PDO(
            dsn: $this->params['dsn'],
            username: $this->params['username'],
            password: $this->params['password'],
            options: $options ?? []
        );
    }

    /**
     * Returns an associated PDO connection, if
     * connection such does not exist tries to establish a new connection.
     *
     * @return PDO
     */
    protected function getPDO(): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = $this->connect();
        }

        return $this->pdo;
    }
}
