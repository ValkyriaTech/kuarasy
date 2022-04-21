<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>It works!</title>

    <style media="screen">
      code {
        color: #b00;
      }
    </style>
  </head>
  <body>
    <h1>Hello, world!</h1>
    <p>You are seeing a view. It's located in <code>/views/example</code>. Thiw view is setted as default in <code>/config.php</code></p>
    <a href="//<?= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ?>example/test">Access the subview</a>
  </body>
</html>
