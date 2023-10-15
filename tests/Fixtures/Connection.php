<?php

namespace Nulldark\Tests\Fixtures;

use Nulldark\DBAL\Contract\DriverInterface;

class Connection extends \Nulldark\DBAL\Connection
{
    public function __construct()
    {
        parent::__construct([
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../Stubs/stubs.db'
        ]);
    }
}
