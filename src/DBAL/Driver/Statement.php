<?php

namespace Nulldark\DBAL\Driver;

interface Statement
{

    /**
     * @param array $params
     * @return Result
     */
    public function execute(array $params): Result;
}