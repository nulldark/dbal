<?php

namespace Nulldark\DBAL\Database\MySQL;

use Nulldark\DBAL\Contract\ConnectionInterface;
use Nulldark\DBAL\Contract\DriverInterface;
use Nulldark\DBAL\Database\BaseDriver;
use PDO;
use SensitiveParameter;

final class MySQLDriver extends BaseDriver implements DriverInterface
{
    /**
     * @inheritDoc
     */
    public function connect(#[SensitiveParameter] array $params): ConnectionInterface
    {
        $safeParams = $params;

        unset($safeParams['username']);
        unset($safeParams['password']);

        if (!empty($params['persistent'])) {
            $params['options'][PDO::ATTR_PERSISTENT] = true;
        }

        return new MySQLConnection(
            new PDO(
                $this->dsn('mysql', $safeParams),
                $params['username'],
                $params['password'],
                $params['options'] ?? []
            )
        );
    }
}
