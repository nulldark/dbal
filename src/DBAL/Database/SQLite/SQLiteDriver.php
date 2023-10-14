<?php

namespace Nulldark\DBAL\Database\SQLite;

use Nulldark\DBAL\Contract\ConnectionInterface;
use Nulldark\DBAL\Contract\DriverInterface;
use Nulldark\DBAL\Database\BaseDriver;
use SensitiveParameter;

final class SQLiteDriver extends BaseDriver implements DriverInterface
{
    /**
     * @inheritDoc
     */
    public function connect(#[SensitiveParameter] array $params): ConnectionInterface
    {
        return new SQLiteConnection(
            new \PDO("sqlite:{$params['database']}")
        );
    }
}
