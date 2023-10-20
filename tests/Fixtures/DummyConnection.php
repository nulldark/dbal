<?php

namespace Nulldark\Tests\Fixtures;

use Nulldark\DBAL\Database\SQLite\SQLiteDriver;

class DummyConnection extends \Nulldark\DBAL\Connection
{
    public function __construct()
    {
        parent::__construct(
            name: 'default',
            driver: new SQLiteDriver([ 'dsn' => 'sqlite::../Stubs/stubs.db' ])
        );
    }
}
