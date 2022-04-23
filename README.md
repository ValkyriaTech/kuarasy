# Kûarasy
Just a simple PHP - MySQL framework

## About
This is a very simple and basic PHP - MySQL framework. Help us improve it. Use as you wish.

## Installation
Update the database connection details in <code>config.php</code>

### Default view
As default, **DEFAULT_VIEW** is defined in <code>config.php</code>. It holds the directory name of your main frontpage.  
**Load** other views and web apps using the basic function *load('view_name')* from <code>/views/Default.php</code>

### REST API
The basic REST API in this framework uses a **action** request field to define the task / route  
This **action** will call a method with same name from <code>/views/Base.php</code> or any of it's properties

After installation test it: [http://localhost/kuarasy?action=status](http://localhost/kuarasy?action=status)

### Cron jobs
Each task uses a **task** field for identification. Try this on console:  
```
php index.php task=say_hello
```
