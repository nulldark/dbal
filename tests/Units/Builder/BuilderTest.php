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

namespace Nulldark\Tests\Units\Builder;

use Nulldark\DBAL\Builder\Builder;
use Nulldark\DBAL\Builder\BuilderInterface;
use Nulldark\DBAL\Builder\Grammars\Grammar;
use Nulldark\Tests\Fixtures\DummyConnection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Builder::class)]
class BuilderTest extends TestCase
{
    private BuilderInterface $builder;

    public function setUp(): void
    {
        $this->builder = new Builder(
            new DummyConnection()
        );

        parent::setUp();
    }

    public function testConstructor(): void
    {
        $this->assertInstanceOf(BuilderInterface::class, $this->builder);
        $this->assertInstanceOf(Grammar::class, $this->builder->grammar);
    }

    public function testSelectWithDefaultValue(): void
    {
        $query = $this->builder->select();

        $this->assertInstanceOf(BuilderInterface::class, $query);
        $this->assertEquals(['*'], $query->columns);
    }

    public function testSelectWithColumns(): void
    {
        $this->assertEquals(
            ['id', 'name'],
            $this->builder->select('id', 'name')->columns
        );
    }

    public function testFromWithoutAlias(): void
    {
        $this->assertEquals(
            'foo',
            $this->builder->from('foo')->from
        );
    }

    public function testFromWithAlias(): void
    {
        $this->assertEquals(
            'foo AS f',
            $this->builder->from('foo', 'f')->from
        );
    }

    public function testWhere(): void
    {
        $this->builder->where('foo', '=', 'bar');

        $this->assertCount(1, $this->builder->wheres);
        $this->assertEquals([
            'type' => 'Basic',
            'column' => 'foo',
            'operator' => '=',
            'value' => 'bar',
            'boolean' => 'AND'
        ], $this->builder->wheres[0]);
    }

    public function testSqlCompiler(): void
    {
        $this->builder
            ->select('f.id', 'f.name')
            ->from('foo', 'f')
            ->where('f.name', '=', 'foo');

        $this->assertEquals('SELECT f.id, f.name FROM foo AS f WHERE f.name = foo', $this->builder->toSQL());
    }
}
