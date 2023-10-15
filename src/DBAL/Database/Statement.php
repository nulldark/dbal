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

use Nulldark\Collection\CollectionInterface;

/**
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Database
 * @license LGPL-2.1
 * @version 0.3.0
 */
final readonly class Statement
{
    public function __construct(private \PDOStatement $statement)
    {

    }

    /**
     * @param array $params
     * @return CollectionInterface
     */
    public function execute(array $params = []): CollectionInterface
    {
        try {
            $this->statement->execute($params);
        } catch (\PDOException $exception) {
            throw $exception;
        }

        return new RecordCollection($this->statement);
    }
}
