## nulldark/dbal

The DataBase Abstract Layer providing a fluent query and other many features. It currently supports MySQL, Postgres 
and SQLite based on PDO. 

### WARNING
NOTE: The library is under development, the API is currently taking shape but there should be no breaking changes. 
It is currently not recommended to use on production!

### Usage Instructions

First, create new Connection.
```php
$connection = new \Nulldark\DBAL\Connection([
    'driver' => 'mysql',
    'dsn' => 'mysql:host=127.0.0.1;dbname=foo',
    'username' => 'root',
    'password' => 'password',
]);
```

**Using The Query Builder**
```php
$results = $connection->getQueryBuilder()
    ->select('*')
    ->from('table')
    ->where('id', '>', 3)
    ->get();
```

**Using The Core Methods**
```php
// Simple Query
$results = $connection->query('SELECT id FROM table WHERE id = 1')
    ->fetchAllObject();

// Prepared Statements
$stmt = $connection->prepare('SELECT id FROM table WHERE id = ?')->execute();
$results = $stmt->execute()
    ->fetchAllObject();
```
