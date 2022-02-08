<?php

class Api {

  private $default;

  public function __construct() {
    $this->default = new DefaultView();
  }

  public function interpretAction($action) {
    switch ($action) {

      case 'status':
        $this->default->checkStatus();
        break;

      case 'uploadFile':
        $this->default->uploadFile();
        break;

      case 'example':
        echo 'Hello, world!';
        break;

      default:
        $this->default->error();
        break;
    }
  }
}
