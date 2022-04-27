# Kûarasy
Just a simple PHP - MySQL framework

## About
This is a very simple and basic PHP - MySQL framework. Help us improve it. Use as you wish.

## Installation
1 - Update the database connection details in <code>/config.php</code>:
```php
define('K_DB_NAME', '');
define('K_DB_USER', '');
define('K_DB_PASSWORD', '');
```
2 - If you are **NOT** running directly on server root, set the BASEPATH reference in <code>/config.php</code>:
```php
define('BASEPATH', '/kuarasy'); // assuming you are running from https://localhost/kuarasy
```
and <code>/.htaccess</code>:
```
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_URI} !(.*)/$
# Force Trailing slash
RewriteRule ^((.*)[^/])$ /kuarasy/$1/ [L,R=301] # HERE

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /kuarasy/index.php [L] # AND HERE
```

### Default view
As default, **DEFAULT_VIEW** is defined in <code>config.php</code>. It holds the directory name of your main frontpage.  
**Load** other views and web apps using the basic function *load('view_name')* from <code>/views/Default.php</code>

### REST API
The basic REST API in this framework uses a **action** request field to define the task / route
See how it works in <code>/controllers/Api.php</code>

After installation test it: [http://localhost/kuarasy?action=status](http://localhost/kuarasy?action=status)

### Cron jobs
Each task uses a **task** field for identification. Try this:  
```
php index.php task=say_hello
```

### PDO Statement Query Builder
<code>models/Item::statementQueryBuilder($type, $fields = null, $where = null)</code>  
Simple PDO query builder for common SQL operations.  
Create a new class from **models/Item** and set <code>tableName</code> value in constructor. Check [models/Example](https://github.com/ValkyriaTech/kuarasy/blob/main/models/Example.php) for help.  
#### Examples
- SELECT  
```php
$stmt = $this->statementQueryBuilder(
  // type
  'select',
  [
    'name',
    'lastname'
  ],
  // where
  [
    [
      'field' => 'id',
      'operator' => '=', // =, <=, >=
      'value' => 8
    ]
  ]
);

if ($stmt->execute())
  return $stmt->fetch(PDO::FETCH_ASSOC);
else
  $this->helper->log->generateLog('Error during SQL exec :(');
```
- INSERT  
```php
$stmt = $this->statementQueryBuilder(
  // type
  'insert',
  // field => value
  [
    'name' => 'Wade',
    'lastname' => 'Watts'
  ]
);

if ($stmt->execute())
  return $stmt->rowCount();
else
  $this->helper->log->generateLog('Error during SQL exec :(');
```
- UPDATE  
```php
$stmt = $this->statementQueryBuilder(
  // type
  'update',
  // field => value
  [
    'name' => 'Jill',
    'lastname' => 'Valentine'
  ],
  // where
  [
    [
      'field' => 'id',
      'operator' => '=', // =, <=, >=
      'value' => 6
    ]
  ]
);

if ($stmt->execute())
  return $stmt->rowCount();
else
  $this->helper->log->generateLog('Error during SQL exec :(');
```
- DELETE
```php
$stmt = $this->statementQueryBuilder(
  // type
  'delete',
  null,
  // where
  [
    [
      'field' => 'id',
      'operator' => '=', // =, <=, >=
      'value' => 69
    ]
  ]
);

if ($stmt->execute())
  return $stmt->rowCount();
else
  $this->helper->log->generateLog('Error during SQL exec :(');
```
