<?php

namespace Nulldark\DBAL\Exception;

use InvalidArgumentException;
use Throwable;

class MissingDriverException extends InvalidArgumentException
{

    public function __construct(string $driver = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf("Driver '%s' not supported yet.", $driver), $code, $previous);
    }

}