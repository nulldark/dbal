<?php

namespace Nulldark\DBAL\Database;

abstract class BaseDriver
{
    /**
     * Build DSN connection string.
     *
     * @param string $driver
     * @param string[] $params
     * @return string
     */
    protected function dsn(string $driver, array $params): string
    {
        $dsn = "$driver:";

        if (isset($params['host'])) {
            $dsn .= "host={$params['host']};";
        }

        if (isset($params['port'])) {
            $dsn .= "port={$params['port']};";
        }

        if (isset($params['dbname'])) {
            $dsn .= "dbname={$params['dbname']}";
        }

        if (isset($params['charset'])) {
            $dsn .= "charset={$params['charset']}";
        }

        return $dsn;
    }
}
