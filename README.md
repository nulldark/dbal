# nulldark/dbal

## API Reference
### Connection
```php
$config = [
    'autoCommit' => FALSE,
    'loggingQuery' => FALSE
];
    
$params = [
    'driver' => '',
    'username' = '',
    'password' => '',
    'dbname' => ''
];
    
$connection = \Nulldark\DBAL\ConnectionFactory($params, $config);
```

### Prepares and executes an SQL query and returns the result.
`fetch(string $sql, array $params = [], int $mode = \PDO::FETCH_ASSOC): array`

```php
$connection->fetch('SELECT 1+1');
$connection->fetch('SELECT id FROM table WHERE id = ?', [3]);
```

### Prepares and executes an SQL query and returns the value of the first row of the result.
`fetchOne(string $sql, array $params = [], int $mode = \PDO::FETCH_ASSOC): mixed`
```php
$connection->fetchOne('SELECT 1+1');
$connection->fetchOne('SELECT id FROM table WHERE id = ?', [3]);
```

### Prepares and executes an SQL query and returns the number of changed rows.
`execute(string $sql, array $params = []): int`
```php
$connection->execute('INSERT INTO table VALUES(3);')
```

### Prepares and executes an SQL query.
`query(string $sql, array $params = []): Result`
```php
$connection->query('SELECT 1+1');
```

### Transaction
`beginTransaction(): bool`
`commit(): bool`
`rollback(): bool`

```php
$connection->beginTransaction();
$connection->commit();
$connection->rollBack();
```