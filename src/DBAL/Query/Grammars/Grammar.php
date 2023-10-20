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

namespace Nulldark\DBAL\Query\Grammars;

use Nulldark\DBAL\Query\QueryBuilder;

/**
 * @internal
 *
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Builder\Grammars
 * @license LGPL-2.1
 * @version 0.3.0
 */
class Grammar
{
    /** @var array|string[] $components */
    protected array $components = [
        'columns',
        'from',
        'wheres'
    ];

    /**
     * Compiling the provided Builder.
     *
     * @param QueryBuilder $query
     * @return string
     */
    public function compile(QueryBuilder $query): string
    {
        return trim(
            $this->concatenate(
                $this->buildComponents($query)
            )
        );
    }


    /**
     * Build all components based on $this->components.
     *
     * @param QueryBuilder $query
     * @return string[]
     */
    protected function buildComponents(QueryBuilder $query): array
    {
        $sql = [];

        foreach ($this->components as $component) {
            if (isset($query->$component)) {
                $sql[$component] = $this->{'build' . ucfirst($component)}($query, $query->$component);
            }
        }

        return $sql;
    }

    /**
     * Build column component.
     *
     * @param QueryBuilder $query
     * @param string[] $columns
     * @return string|null
     */
    protected function buildColumns(QueryBuilder $query, array $columns): ?string
    {
        return "SELECT " . implode(', ', $columns);
    }

    /**
     * Build from component
     *
     * @param QueryBuilder $query
     * @param string $table
     * @return string
     */
    protected function buildFrom(QueryBuilder $query, string $table): string
    {
        return "FROM " . $table;
    }

    /**
     * Build where component.
     *
     * @param QueryBuilder $query
     * @param array<string[]> $wheres
     * @return string
     */
    protected function buildWheres(QueryBuilder $query, array $wheres): string
    {
        if (count($sql = $this->buildWheresToArray($query)) > 0) {
            return "WHERE " . preg_replace('/and |or /i', '', implode(" ", $sql), 1);
        }

        return "";
    }

    /**
     * Build all conditions to array.
     *
     * @param QueryBuilder $query
     * @return string[]
     */
    protected function buildWheresToArray(QueryBuilder $query): array
    {
        return array_map(function ($where) use ($query) {
            assert(is_string($where['type']));

            return $where['boolean'] . ' ' . $this->{"where{$where['type']}"}($query, $where);
        }, $query->wheres);
    }

    /**
     * Build basic where clause.
     *
     * @param QueryBuilder $query
     * @param string[] $where
     * @return string
     */
    protected function whereBasic(QueryBuilder $query, array $where): string
    {
        return $where['column'] . ' ' . $where['operator'] . ' ' . $where['value'];
    }

    /**
     * Concat all components.
     *
     * @param string[] $segments
     * @return string
     */
    protected function concatenate(array $segments): string
    {
        return implode(' ', array_filter($segments, function ($value) {
            return (string) $value !== '';
        }));
    }
}
