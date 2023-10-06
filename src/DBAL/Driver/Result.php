<?php

namespace Nulldark\DBAL\Driver;

interface Result
{

    /**
     * @param array $params
     * @return bool
     */
    public function execute(array $params): bool;

    /**
     * @param int $mode
     * @return array
     */
    public function fetchAll(int $mode): array;

    /**
     * @param int $mode
     * @return mixed
     */
    public function fetchOne(int $mode): mixed;

    /**
     * @return int
     */
    public function rowCount(): int;

    /**
     * @return int
     */
    public function rowColumn(): int;
}