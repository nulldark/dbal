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
 * @author Damian Mosiński
 * @package Nulldark\DBAL\Contract\Builder\Grammars
 * @license LGPL-2.1
 * @since 0.5.0
 */
interface GrammarInterface
{
    /**
     * Compiles the provided Builder.
     *
     * @param QueryBuilder $query
     * @return string
     */
    public function compile(QueryBuilder $query): string;

    /**
     * Builds a SELECT Query.
     *
     * @param QueryBuilder $query
     * @return string
     *
     * @since 0.6.0
     * */
    public function buildSelectSQL(QueryBuilder $query): string;

    /**
     * Builds a INSERT Query.
     *
     * @param QueryBuilder $query
     * @return string
     *
     *
     * @since 0.6.0
     */
    public function buildInsertSQL(QueryBuilder $query): string;

    /**
     * Builds a UPDATE Query.
     *
     * @param QueryBuilder $query
     * @return string
     *
     * @since 0.6.0
     */
    public function buildUpdateSQL(QueryBuilder $query): string;

    /**
     * Builds a DELETE Query.
     *
     * @param QueryBuilder $query
     * @return string
     *
     * @since 0.6.0
     */
    public function buildDeleteSQL(QueryBuilder $query): string;

    /**
     * Compiles SELECT clauses into SQL.
     *
     * @param QueryBuilder $query
     * @return string
     *
     * @since 0.5.0
     */
    public function compileSelects(QueryBuilder $query): string;

    /**
     * Compiles FROM clauses into SQL.
     *
     * @param QueryBuilder $query
     * @return string
     *
     * @since 0.5.0
     */
    public function compileFroms(QueryBuilder $query): string;

    /**
     * Compiles conditions into SQL.
     *
     * @param QueryBuilder $query
     * @return string
     *
     * @since 0.6.0
     */
    public function compileConditions(QueryBuilder $query): string;

    /**
     * Compiles ORDER BY clauses into SQL.
     *
     * @param QueryBuilder $query
     * @return string
     *
     * @since 0.6.0
     */
    public function compileOrders(QueryBuilder $query): string;
}
