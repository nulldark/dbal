<?php

namespace Nulldark\DBAL\Driver\PDO\MySQL;

use Exception;
use Nulldark\DBAL\Driver\PDO\Connection;
use PDO;
use PDOException;
use SensitiveParameter;

class Driver implements \Nulldark\DBAL\Driver\Driver
{
    public function connect(#[SensitiveParameter] array $params): \Nulldark\DBAL\Driver\Connection
    {
        $safeParams = $params;

        unset($safeParams['username']);
        unset($safeParams['password']);

        if (!empty($params['persistent'])) {
            $params['options'][PDO::ATTR_PERSISTENT] = true;
        }

        try {
            $pdo = new PDO(
                $this->dsn($safeParams),
                $params['username'],
                $params['password'],
                $params['options'] ?? []
            );
        } catch (PDOException $exception) {
            throw new Exception(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return new Connection(
            $pdo
        );
    }

    private function dsn(array $params): string
    {
        $dsn = 'mysql:';

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
