<?php

namespace Nulldark\DBAL\Database\SQLite;

use Nulldark\DBAL\Contract\ConnectionInterface;
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
    public function query(string $query): array
    {
        return $this->pdo->query($query)->fetchAll();
    }

    /**
     * @inheritDoc
     */
    public function prepare(string $query): false|PDOStatement
    {
        return $this->pdo->prepare($query);
    }
}
