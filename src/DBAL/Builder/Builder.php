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

namespace Nulldark\DBAL\Builder;

use InvalidArgumentException;
use Nulldark\Collection\CollectionInterface;
use Nulldark\DBAL\Builder\Grammars\Grammar;
use Nulldark\DBAL\Connection;
use Nulldark\DBAL\Contract\Builder\BuilderInterface;

/**
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Builder
 * @license LGPL-2.1
 * @version 0.3.0
 */
class Builder implements BuilderInterface
{
    /** @var Grammar $grammar */
    public Grammar $grammar;

    /** @var array|string[] $operators */
    public array $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
    ];

    /** @var string[] $columns */
    public array $columns;

    /** @var string $from */
    public string $from;

    /** @var array<string[]> $wheres */
    public array $wheres;

    /** @var Connection $connection */
    private Connection $connection;

    public function __construct(
        Connection $connection,
        Grammar $grammar = null
    ) {
        $this->connection = $connection;
        $this->grammar = $grammar ?: new Grammar();
    }

    /**
     * @inheritDoc
     */
    public function select(string ...$columns): self
    {
        $this->columns = [];

        if (empty($columns)) {
            $columns = ['*'];
        }

        foreach ($columns as $column) {
            $this->columns[] = $column;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function from(string $table, string $as = null): self
    {
        $this->from = $as === null ? $table : "$table AS $as";
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function where(string $column, string $operator, string|array|float|int $values, string $boolean = 'AND'): BuilderInterface
    {
        [$value, $operator] = $this->prepareValueAndOperator(
            $values,
            $operator,
            func_num_args() === 2
        );

        $type = match ($operator) {
            default => 'Basic'
        };

        $this->wheres[] = compact(
            'type',
            'column',
            'operator',
            'value',
            'boolean'
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toSQL(): string
    {
        return $this->grammar->compile($this);
    }

    /**
     * @inheritDoc
     */
    public function get(): CollectionInterface
    {
        return $this->connection->select(
            $this->toSQL()
        );
    }

    /**
     * @param string|float|int|array<int|float|string> $value
     * @param string $operator
     * @param bool $useDefault
     * @return string[]
     *
     * @throws InvalidArgumentException
     */
    private function prepareValueAndOperator(float|int|array|string $value, string $operator, bool $useDefault = false): array
    {
        if ($useDefault) {
            return [$operator, '='];
        } elseif (in_array($operator, $this->operators) && !in_array($operator, ['=', '<>', '!='])) {
            throw new InvalidArgumentException('Illegal operator and value combination.');
        }

        return [$value, $operator];
    }
}
