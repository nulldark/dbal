<?php

namespace Nulldark\DBAL\Driver\PDO;

use PDO;
use PDOStatement;

final readonly class Result implements \Nulldark\DBAL\Driver\Result
{
    public function __construct(
        private PDOStatement $statement
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(int $mode = PDO::FETCH_ASSOC): array
    {
        return $this->statement->fetchAll($mode);
    }

    /**
     * @inheritDoc
     */
    public function fetchOne(int $mode = PDO::FETCH_ASSOC): mixed
    {
        return $this->statement->fetch($mode);
    }

    /**
     * @inheritDoc
     */
    public function rowCount(): int
    {
        return $this->statement->rowCount();
    }

    /**
     * @inheritDoc
     */
    public function rowColumn(): int
    {
        return $this->statement->columnCount();
    }

    /**
     * @inheritDoc
     */
    public function execute(array $params = []): bool
    {
        return $this->statement->execute($params);
    }
}