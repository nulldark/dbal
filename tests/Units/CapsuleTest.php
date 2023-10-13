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

namespace Nulldark\Tests\Units;

use Nulldark\DBAL\Capsule;
use Nulldark\DBAL\Contract\CapsuleInterface;
use Nulldark\DBAL\Contract\ConnectionInterface;
use Nulldark\DBAL\Contract\DriverFactoryInterface;
use Nulldark\DBAL\Exception\UnsupportedDriverException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Capsule::class)]
class CapsuleTest extends TestCase
{
    public function testConstructor(): void
    {
        $capsule = new Capsule();

        $this->assertInstanceOf(CapsuleInterface::class, $capsule);
        $this->assertInstanceOf(DriverFactoryInterface::class, $capsule->getDriverFactory());
    }

    public function testDriverFactoryIsInstanceOfDriverFactoryInstance(): void
    {
        $capsule = new Capsule();

        $this->assertInstanceOf(DriverFactoryInterface::class, $capsule->getDriverFactory());
    }

    public function testCreateConnectionReturnsConnectionInterface(): void
    {
        $capsule = new Capsule();

        $this->assertInstanceOf(
            ConnectionInterface::class,
            $capsule->createConnection(['driver' => 'inmemory'])
        );
    }

    public function testCreateConnectionThrowsExceptionWhenMissingDriverOption(): void
    {
        $this->expectException(UnsupportedDriverException::class);

        $capsule = new Capsule();
        $capsule->createConnection([]);
    }
}