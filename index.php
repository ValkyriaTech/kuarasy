<?php

require_once('config.php');
require_once('Helper.php');
require_once('./controllers/Api.php');
require_once('./controllers/Cron.php');
require_once('./views/Base.php');

// check  for API action
$pathInfo = array_filter(explode('/', str_replace(BASEPATH, '', $_SERVER['REQUEST_URI'])));
$firstSegment = strtolower(reset($pathInfo) ?? '');

if ($firstSegment === 'api' && isset($pathInfo[1])) {
    // get api action key from array (next index after 'api') 
    $actionKey = key($pathInfo) + 1;
    $action = $pathInfo[$actionKey];

    $api = new Api();
    $api->interpretAction($action);

    exit;
} else if (!empty($argv)) {

  parse_str($argv[1], $params);
  $task = $params['task'];

  $cron = new Cron($task);
  $cron->execute();

  exit;
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
