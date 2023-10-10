<?php

namespace Nulldark\DBAL\Driver;

interface Connection
{
    /**
     * @param string $sql
     * @return Statement
     */
    public function prepare(string $sql): Statement;

    /**
     * @param string $sql
     * @return mixed
     */
    public function query(string $sql): mixed;

    /**
     * @param string $sql
     * @return int
     */
    public function exec(string $sql): int;

    /**
     * @return bool
     */
    public function transaction(): bool;

    /**
     * @return bool
     */
    public function commit(): bool;

    /**
     * @return bool
     */
    public function rollback(): bool;
}
