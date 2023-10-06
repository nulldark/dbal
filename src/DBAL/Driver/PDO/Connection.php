<?php

namespace Nulldark\DBAL\Driver\PDO;

use PDO;
use PDOException;

final readonly class Connection implements \Nulldark\DBAL\Driver\Connection
{
    public function __construct(
        private PDO $connection)
    {
    }

    /**
     * @inheritDoc
     */
    public function prepare(string $sql): Statement
    {
        try {
            return new Statement(
                $this->connection->prepare($sql)
            );
        } catch (PDOException $exc) {
            throw new $exc;
        }
    }

    /**
     * @inheritDoc
     */
    public function query(string $sql): \Nulldark\DBAL\Driver\Result
    {
        try {
            return new Result(
                $this->connection->query($sql)
            );
        } catch (PDOException $exception) {
            throw new $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function exec(string $sql): int
    {
        try {
            return $this->connection->exec($sql);
        } catch (PDOException $exception) {
            throw new $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function transaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    /**
     * @inheritDoc
     */
    public function commit(): bool
    {
        return $this->connection->commit();
    }

    /**
     * @inheritDoc
     */
    public function rollback(): bool
    {
        return $this->connection->rollBack();
    }
}