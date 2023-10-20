<?php

namespace Nulldark\Tests\Units\Database;

use Nulldark\DBAL\Database\GenericDriverFactory;
use Nulldark\DBAL\Database\GenericDriverInterface;
use Nulldark\DBAL\Database\MySQL\MySQLDriver;
use Nulldark\DBAL\Exception\UnsupportedDriverException;
use Nulldark\Tests\Stubs\Params;
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
