<?php

require_once(dirname(__DIR__, 1) . '/views/Base.php');

class Api {

  private $view;

  public function __construct() {
    $this->view = new BaseView();
  }

  public function interpretAction($action) {
    switch ($action) {

      case 'status':
        $this->view->checkStatus();
        break;

      case 'uploadFile':
        $this->view->uploadFile();
        break;

      case 'example':
        echo 'Hello, world!';
        break;

      default:
        $this->view->error();
        break;
    }
  }
}
