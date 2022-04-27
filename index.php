<?php

require_once('config.php');
require_once('Helper.php');
require_once('./controllers/Api.php');
require_once('./controllers/Cron.php');
require_once('./views/Base.php');

$action = $_REQUEST['action'] ?? null;
if ($action) {

  $api = new Api();
  $api->interpretAction($action);

} else if (!empty($argv)) {

  parse_str($argv[1], $params);
  $task = $params['task'];

  $cron = new Cron($task);
  $cron->execute();

} else {

  $viewObj = new BaseView();

  $pathInfo = array_filter(explode('/', str_replace(BASEPATH, '', $_SERVER['REQUEST_URI'])));

  $view = strtok(current($pathInfo), '?');
  $path = (count($pathInfo) > 1) ? end($pathInfo) : null;

  if (!empty($view) && $viewObj->viewExists($view))
    $viewObj->load($view, $path);
  else
    $viewObj->load();

}
