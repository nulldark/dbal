<?php

namespace Abyss\Tests\Fixtures;

use Abyss\DBAL\Database\SQLite\SQLiteDriver;

class DummyConnection extends \Abyss\DBAL\Connection
{
    public function __construct()
    {
        parent::__construct(
            name: 'default',
            driver: new SQLiteDriver([ 'dsn' => 'sqlite::../Stubs/stubs.db' ])
        );
    }
}
