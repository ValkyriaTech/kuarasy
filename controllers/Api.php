<?php

require_once('Upload.php');

class Api {

  private $default;
  private $upload;

  public function __construct() {
    $this->default = new DefaultView();
    $this->upload = new UploadController();
  }

  public function interpretAction($action) {
    switch ($action) {

      case 'status':
        $this->default->checkStatus();
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
