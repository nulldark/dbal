<?php

namespace Nulldark\DBAL\Exception;

use Exception;
use Throwable;

class QueryException extends Exception
{
    public function __construct(string $query, array $params = [], Throwable $previous = null)
    {
        parent::__construct(
            sprintf("QUERY: %s\nPARAMS: %s", $query, print_r($params, true)),
            0,
            $previous
        );
    }
}