<?php

namespace Nulldark\DBAL;

use PDO;

final readonly class Result
{
    public function __construct(private Driver\Result $result)
    {
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->result->rowCount();
    }

    /**
     * @param int $mode
     * @return mixed
     */
    public function fetch(int $mode = PDO::FETCH_ASSOC): mixed
    {
        return $this->result->fetchOne($mode);
    }

    /**
     * @param int $mode
     * @return array
     */
    public function fetchAll(int $mode = PDO::FETCH_ASSOC): array
    {
        return $this->result->fetchAll($mode);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function execute(array $params = []): bool
    {
        return $this->result->execute($params);
    }
}
