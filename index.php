<?php

require_once('config.php');
require_once('controllers/Api.php');
require_once('views/Default.php');

$action = $_REQUEST['action'] ?? null;
$scheduledTask = $_REQUEST['scheduled'] ?? null;

if ($action) {

  $api = new Api();
  $api->interpretAction($action);

} elseif ($scheduledTask) {

  $key = $_REQUEST['key'];
  if ($scheduledTask == 'say_hello' && $key == EXAMPLE_TASK) {
    echo 'Task: Hello, World!';
  }

} else {

  $defaultView = new DefaultView();

  $path = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
  if(!empty($path) && $defaultView->pathExists($path))
    $defaultView->load($path);
  else
    $defaultView->load();

}
