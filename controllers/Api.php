<?php

require_once(dirname(__DIR__, 1) . '/views/Base.php');

class Api {

  private $view;

  public function __construct() {
    $this->view = new BaseView();
  }

  private function sanitizeAction($action) {
    if (empty($action))
      $this->view->error();

    if (!is_string($action))
      $this->view->error();

    // remove spaces
    $action = str_replace(' ', '_', $action);

    return preg_replace('/[^A-Za-z0-9\-\_]/', '', $action);
  }

  public function interpretAction($action) {
    $this->view->canCallMethod($this->sanitizeAction($action));
  }
}
