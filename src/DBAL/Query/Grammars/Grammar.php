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

namespace Abyss\DBAL\Query\Grammars;

use Abyss\DBAL\Query\QueryBuilder;
use Abyss\DBAL\Query\QueryBuilderInterface;
use Abyss\DBAL\Query\QueryType;

/**
 * @internal
 *
 * @author Dominik Szamburski
 * @package Abyss\DBAL\Builder\Grammars
 * @license LGPL-2.1
 * @since 0.3.0
 */
class Grammar implements GrammarInterface
{
    /**
     * @inheritDoc
     */
    public function compile(QueryBuilderInterface $query): string
    {
        return match ($query->type) {
            QueryType::SELECT => $this->buildSelectSQL($query),
            QueryType::INSERT => $this->buildInsertSQL($query),
            QueryType::UPDATE => $this->buildUpdateSQL($query),
            QueryType::DELETE => $this->buildDeleteSQL($query)
        };
    }

    /**
     * @inheritDoc
     */
    public function buildSelectSQL(QueryBuilder $query): string
    {
        return $this->compileSelects($query) . ' '
            . $this->compileFroms($query)
            . ($query->conditions === [] ? '' :  ' ' . $this->compileConditions($query))
            . ($query->orders === [] ? '' : ' ' . $this->compileOrders($query))
            . ($query->limit === 0 ? '' : ' ' . $this->compileLimit($query));
    }

    /**
     * @inheritDoc
     */
    public function buildInsertSQL(QueryBuilder $query): string
    {
        foreach ($query->values as $key => $value) {
            ksort($value);
            $query->values[$key] = $value;
        }

        $values = array_map(function ($record) {
            return '( ' . implode(', ', array_map(fn ($parameter) => "'$parameter'", $record)) . ' )';
        }, $query->values);

        return 'INSERT INTO ' . $query->table
            . '(' .  implode(', ', array_keys((array) current($query->values))) . ') '
            . 'VALUES ' . implode(', ', $values);
    }

    /**
     * @inheritDoc
     */
    public function buildUpdateSQL(QueryBuilder $query): string
    {
        return "";
    }

    /**
     * @inheritDoc
     */
    public function buildDeleteSQL(QueryBuilder $query): string
    {
        return 'DELETE FROM '
            . $query->table
            . ($query->conditions === [] ? '' : $this->compileConditions($query));
    }

    /**
     * @inheritDoc
     */
    public function compileSelects(QueryBuilder $query): string
    {
        return 'SELECT ' .  implode(', ', $query->columns);
    }

    /**
     * @inheritDoc
     */
    public function compileFroms(QueryBuilder $query): string
    {
        return 'FROM ' . implode(', ', $query->from);
    }
    /**
     * @inheritDoc
     */
    public function compileConditions(QueryBuilder $query): string
    {
        $sql = array_map(function ($where) {
            return strtolower($where['boolean'])
                . ' ' . $where['column']
                . ' ' . $where['operator']
                . ' ' . $where['value'];
        }, $query->conditions);

        return 'WHERE ' . preg_replace('/and |or /i', '', implode(" ", $sql), 1);
    }

    /**
     * @inheritDoc
     */
    public function compileOrders(QueryBuilder $query): string
    {
        return 'ORDER BY ' . implode(', ', $query->orders);
    }

    /**
     * @inheritDoc
     */
    public function compileLimit(QueryBuilder $query): string
    {
        return '';
    }
}
