<?php

namespace Nulldark\DBAL;

use Closure;
use Exception;
use Nulldark\DBAL\Driver\Driver;
use Nulldark\DBAL\Exception\QueryException;
use PDO;
use SensitiveParameter;

final class Connection
{
    /** @var bool $autoCommit */
    private bool $autoCommit = false;
    /** @var bool $loggingQuery */
    private bool $loggingQuery = false;
    /** @var null|\Nulldark\DBAL\Driver\Connection $connection */
    private ?\Nulldark\DBAL\Driver\Connection $connection = null;
    /** @var Driver $_driver */
    private Driver $_driver;
    /** @var array $_params */
    private array $_params;

    /** @var array $_configuration */
    private array $_configuration;

    /** @var array $queries */
    private array $queries = [];

    /**
     * @param array<string, mixed> $params
     * @param array $configuration
     * @param Driver $driver
     */
    public function __construct(
        #[SensitiveParameter]
        array  $params,
        array  $configuration,
        Driver $driver
    )
    {
        $this->_driver = $driver;
        $this->_params = $params;
        $this->_configuration = $configuration;

        if (isset($this->_configuration['autoCommit']) && $this->_configuration['autoCommit'] === TRUE) {
            $this->autoCommit = true;
        }

        if ($this->_configuration['loggingQuery'] === TRUE) {
            $this->loggingQuery = true;
        }
    }

    /**
     * Prepares and executes an SQL query and returns the value of of the first row of the result.
     *
     * @param string $sql
     * @param array $params
     * @param int $mode
     * @return mixed
     */
    public function fetchOne(string $sql, array $params = [], int $mode = PDO::FETCH_ASSOC): mixed
    {
        return $this->query($sql, $params)->fetch($mode);
    }

    /**
     * Prepares and executes an SQL query and returns the result.
     *
     * @param string $sql
     * @param array $params
     * @param int $mode
     * @return array
     */
    public function fetch(string $sql, array $params = [], int $mode = PDO::FETCH_ASSOC): array
    {
        return $this->query($sql, $params)->fetchAll($mode);
    }

    /**
     * Prepares and executes an SQL query.
     *
     * @param string $sql
     * @param array $params
     * @return Result
     * @throws QueryException
     */
    public function query(string $sql, array $params = []): Result
    {
        return $this->run($sql, $params, function ($sql, $params) {
            return new Result(
                count($params) > 0
                    ? $this->connection->prepare($sql)->execute($params)
                    : $this->connection->query($sql)
            );
        });
    }

    /**
     * @param string $query
     * @param array $params
     * @param Closure $callback
     * @return Result
     * @throws QueryException
     */
    private function run(string $query, array $params, Closure $callback): Result
    {
        $start = microtime(true);

        $result = $this->runQueryCallback($query, $params, $callback);

        $this->logQuery(
            $query, $params, round((microtime(true) - $start) * 1000, 2)
        );


        return $result;

    }

    /**
     * @param string $query
     * @param array $params
     * @param Closure $callback
     * @return mixed
     * @throws QueryException
     * @throws Exception
     */
    private function runQueryCallback(string $query, array $params, Closure $callback): mixed
    {
        $this->reconnectIfNeeded();

        try {
            return $callback($query, $params);
        } catch (Exception $exception) {
            throw new QueryException(
                $query, $params, $exception
            );
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    private function reconnectIfNeeded(): void
    {
        if ($this->connection !== null) {
            return;
        }

        $this->connection = $this->_driver->connect($this->_params);

        if ($this->autoCommit) {
            $this->beginTransaction();
        }
    }

    /**
     * Start new transaction.
     *
     * @return bool
     */
    public function beginTransaction(): bool
    {
        return $this->connection->transaction();
    }

    /**
     * @param string $sql
     * @param array $params
     * @param float $time
     * @return void
     */
    private function logQuery(string $sql, array $params, float $time): void
    {
        if ($this->loggingQuery) {
            $this->queries[] = compact('sql', 'params', 'time');
        }
    }

    /**
     * Prepares and executes an SQL query and returns the number of changed rows.
     *
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->count();
    }

    /**
     * Commit pending transactions.
     *
     * @return bool
     */
    public function commit(): bool
    {
        return $this->connection->commit();
    }

    /**
     * Rollback transactions.
     *
     * @return bool
     */
    public function rollback(): bool
    {
        return $this->connection->rollback();
    }

    /**
     * @return array
     */
    public function getLogQuery(): array
    {
        return $this->queries;
    }
}