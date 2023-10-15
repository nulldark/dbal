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

/**
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Database
 * @license LGPL-2.1
 * @version 0.3.0
 */
abstract class BaseDriver
{
    /**
     * Build DSN connection string.
     *
     * @param string $driver
     * @param string[] $params
     * @return string
     */
    protected function dsn(string $driver, array $params): string
    {
        $dsn = "$driver:";

        if (isset($params['host'])) {
            $dsn .= "host={$params['host']};";
        }

        if (isset($params['port'])) {
            $dsn .= "port={$params['port']};";
        }

        if (isset($params['database'])) {
            $dsn .= "dbname={$params['dbname']}";
        }

        if (isset($params['charset'])) {
            $dsn .= "charset={$params['charset']}";
        }

        return $dsn;
    }
}
