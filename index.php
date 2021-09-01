<?php

require_once('config.php');
require_once('controllers/Api.php');
require_once('controllers/Cron.php');
require_once('views/Default.php');

$action = $_REQUEST['action'] ?? null;

if ($action) {

  $api = new Api();
  $api->interpretAction($action);

} elseif (!empty($argv)) {

  parse_str($argv[1], $params);
  $task = $params['task'];

  $cron = new Cron($task);
  $cron->execute();

} else {

  $defaultView = new DefaultView();

  $path = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
  if(!empty($path) && $defaultView->pathExists($path))
    $defaultView->load($path);
  else
    $defaultView->load();

}
