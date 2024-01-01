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

namespace Abyss\DBAL;

/**
 * @author Dominik Szamburski
 * @package Abyss\DBAL
 * @license LGPL-2.1
 * @version 0.5.0
 */
final class Statement
{
    public function __construct(
        private readonly \PDOStatement $statement
    ) {
    }

    /**
     * Binds a value to parameter.
     *
     * @param int|string $param
     * @param mixed $value
     * @param ParameterType $type
     *
     * @return void
     */
    public function bindValue(int|string $param, mixed $value, ParameterType $type = ParameterType::STRING): void
    {
        $pdoType = match ($type) {
            ParameterType::NULL => \PDO::PARAM_NULL,
            ParameterType::INTEGER => \PDO::PARAM_INT,
            ParameterType::STRING => \PDO::PARAM_STR,
            ParameterType::BINARY,
            ParameterType::LARGE_OBJECT => \PDO::PARAM_LOB,
            ParameterType::BOOLEAN => \PDO::PARAM_BOOL
        };

        $this->statement->bindValue($param, $value, $pdoType);
    }

    /**
     * Executes a statement then return Result instance.
     *
     * @return Result
     */
    public function execute(): Result
    {
        $this->statement->execute();

        return new Result(
            $this->statement
        );
    }
}
