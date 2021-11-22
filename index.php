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

  $pathInfo = array_filter(explode('/', str_replace(BASEPATH, '', $_SERVER['REQUEST_URI'])));

  $view = strtok(current($pathInfo), '?');
  $path = (count($pathInfo) > 1) ? end($pathInfo) : null;

  if(!empty($view) && $defaultView->viewExists($view))
    $defaultView->load($view, $path);
  else
    $defaultView->load();

}
