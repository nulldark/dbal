<?php

namespace Nulldark\DBAL\Database\SQLite;

use Nulldark\DBAL\Contract\ConnectionInterface;
use Nulldark\DBAL\Database\RecordCollection;
use Nulldark\DBAL\Database\Statement;
use PDOStatement;

final readonly class SQLiteConnection implements ConnectionInterface
{
    public function __construct(
        private \PDO $pdo
    ) {

    }

    /**
     * @inheritDoc
     */
    public function query(string $query): RecordCollection
    {
        return new RecordCollection(
            $this->pdo->query($query)
        );
    }

    /**
     * @inheritDoc
     */
    public function prepare(string $query): Statement
    {
        return new Statement(
            $this->pdo->prepare($query)
        );
    }
}
