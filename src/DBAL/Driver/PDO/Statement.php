<?php

namespace Nulldark\DBAL\Driver\PDO;

use PDOStatement;

final readonly class Statement implements \Nulldark\DBAL\Driver\Statement
{
    public function __construct(
        private PDOStatement $PDOStatement
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(array $params): \Nulldark\DBAL\Driver\Result
    {
        $this->PDOStatement->execute($params);

        return new Result(
            $this->PDOStatement
        );
    }
}
