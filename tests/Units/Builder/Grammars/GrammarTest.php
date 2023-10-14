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

namespace Nulldark\Tests\Units\Builder\Grammars;

use Nulldark\DBAL\Builder\Builder;
use Nulldark\DBAL\Builder\Grammars\Grammar;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Grammar::class)]
class GrammarTest extends TestCase
{
    private Grammar $grammar;

    public function setUp(): void
    {
        $this->grammar = new Grammar();
        parent::setUp();
    }

    public function testCompile(): void
    {
        $query = (new Builder())->select('*')
            ->from('foo', 'f')
            ->where('f.id', '=', 1);

        $this->assertEquals('SELECT * FROM foo AS f WHERE f.id = 1', $this->grammar->compile($query));
    }
}
