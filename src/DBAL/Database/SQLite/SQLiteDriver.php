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

namespace Nulldark\DBAL\Database\SQLite;

use Nulldark\DBAL\Database\GenericDriver;
use Nulldark\DBAL\Builder\Grammars\SQLiteGrammar;
use Nulldark\DBAL\Contract\Builder\Grammars\GrammarInterface;


/**
 * Provides a Low Level abstraction at top of SQLite.
 *
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Database\SQLite
 * @license LGPL-2.1
 * @version 0.5.0
 */
final class SQLiteDriver extends GenericDriver
{
    /**
     * @inheritDoc
     */
    public function getGrammar(): GrammarInterface
    {
        return new SQLiteGrammar();
    }
}
