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
**Load** other views and web apps using the basic function *load('view_name')* from <code>/views/Base.php</code>

### REST API
The basic REST API in this framework uses a **action** request field to define the task / route  
This **action** will call a method with same name from <code>/views/Base.php</code> or any of it's properties

After installation test it: [http://localhost/kuarasy?action=status](http://localhost/kuarasy?action=status)

### Cron jobs
Each task uses a **task** field for identification. Try this on console:  
```
php index.php task=say_hello
```
