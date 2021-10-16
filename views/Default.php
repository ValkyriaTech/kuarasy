<?php

require_once(dirname(__DIR__, 1) . '/controllers/Helper.php');
require_once(dirname(__DIR__, 1) . '/controllers/Default.php');

class DefaultView {

  protected $helper;
  private $controller;

  public function __construct() {
    $this->helper = new Helper();
    $this->controller = new DefaultController();
  }

  public function load($view = DEFAULT_VIEW, $contents = null) {
    $path = (__DIR__ . '/' . $view);
    if ($path) {
      $files = scandir($path);
      foreach ($files as $key => $value) {
        if (in_array($value, DEFAULT_VIEW_FILENAMES)) {
          include_once($path . '/' . $value);
          break;
        }
      }
    }
  }

  public function pathExists($view) {
    return is_dir(__DIR__ . '/' . $view);
  }

  public function checkStatus() {
    echo $this->controller->checkConnection();
  }

  public function error() {
    echo $this->helper->createMessage(false);
  }
}
