<?php

namespace Abyss\Test\Unit;

use Abyss\DBAL\ConnectionInterface;
use Abyss\DBAL\ConnectionManager;
use Abyss\DBAL\Exception\ConnectionException;
use Abyss\Test\Unit\Stubs\Params;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConnectionManager::class)]
class ConnectionManagerTest extends TestCase
{
    public function testAddConnection(): void
    {
        $manager = new ConnectionManager();
        $manager->addConnection(Params::DEFAULT_OPTIONS, 'foo');

        $this->assertInstanceOf(
            ConnectionInterface::class,
            $manager->connection('foo')
        );
    }

    public function testAddConnectionException()
    {
        $this->expectException(ConnectionException::class);
        $this->expectExceptionMessage("Unable to create connection, no presets for `foo` found.");

        $manager = new ConnectionManager();
        $manager->connection('foo');
    }
}
