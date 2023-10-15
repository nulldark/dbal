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

namespace Nulldark\DBAL\Builder\Grammars;

use Nulldark\DBAL\Builder\Builder;

/**
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Builder
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
     * @param Builder $query
     * @return string
     */
    public function compile(Builder $query): string
    {
        return trim(
            $this->concatenate(
                $this->buildComponents($query)
            )
        );
    }


    /**
     * @param Builder $query
     * @return string[]
     */
    protected function buildComponents(Builder $query): array
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
     * @param Builder $query
     * @param string[] $columns
     * @return string|null
     */
    protected function buildColumns(Builder $query, array $columns): ?string
    {
        return "SELECT " . implode(', ', $columns);
    }

    /**
     * @param Builder $query
     * @param string $table
     * @return string
     */
    protected function buildFrom(Builder $query, string $table): string
    {
        return "FROM " . $table;
    }

    /**
     * @param Builder $query
     * @param array<string[]> $wheres
     * @return string
     */
    protected function buildWheres(Builder $query, array $wheres): string
    {
        if (count($sql = $this->buildWheresToArray($query)) > 0) {
            return "WHERE " . preg_replace('/and |or /i', '', implode(" ", $sql), 1);
        }

        return "";
    }

    /**
     * @param Builder $query
     * @return string[]
     */
    protected function buildWheresToArray(Builder $query): array
    {
        return array_map(function ($where) use ($query) {
            return $where['boolean'] . ' ' . $this->{"where{$where['type']}"}($query, $where);
        }, $query->wheres);
    }

    /**
     * @param Builder $query
     * @param string[] $where
     * @return string
     */
    protected function whereBasic(Builder $query, array $where): string
    {
        return $where['column'] . ' ' . $where['operator'] . ' ' . $where['value'];
    }

    /**
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
