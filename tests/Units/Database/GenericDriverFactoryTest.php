<?php

namespace Abyss\Tests\Units\Database;

use Abyss\DBAL\Database\GenericDriverFactory;
use Abyss\DBAL\Database\GenericDriverInterface;
use Abyss\DBAL\Database\MySQL\MySQLDriver;
use Abyss\DBAL\Exception\UnsupportedDriverException;
use Abyss\Tests\Stubs\Params;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GenericDriverFactory::class)]
class GenericDriverFactoryTest extends TestCase
{
    public function testCreateDriver(): void
    {
        $factory = new GenericDriverFactory();
        $driver = $factory->createDriver(Params::DEFAULT_OPTIONS);

        $this->assertInstanceOf(
            GenericDriverInterface::class,
            $driver
        );

        $this->assertInstanceOf(
            MySQLDriver::class,
            $driver
        );
    }

    public function testCreateDriverException(): void
    {
        $this->expectException(UnsupportedDriverException::class);
        $this->expectExceptionMessage("The given driver 'invalid' is unknown.");

        $factory = new GenericDriverFactory();
        $factory->createDriver(['driver' => 'invalid']);
    }
}
