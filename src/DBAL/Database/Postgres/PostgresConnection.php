<?php

namespace Nulldark\DBAL\Database\Postgres;

use Nulldark\DBAL\Contract\ConnectionInterface;
use Nulldark\DBAL\Database\RecordCollection;
use Nulldark\DBAL\Database\Statement;

final class PostgresConnection implements ConnectionInterface
{
    public function __construct(
        private readonly \PDO $pdo
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
