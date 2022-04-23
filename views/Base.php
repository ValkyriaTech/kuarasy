<?php

require_once(dirname(__DIR__, 1) . '/controllers/Base.php');
require_once(dirname(__DIR__, 1) . '/controllers/Upload.php');

class BaseView {

  private $helper;
  private $controller;
  private $upload;

  public function __construct() {
    $this->helper = new Helper();
    $this->controller = new BaseController();
    $this->upload = new UploadController();
  }

  public function load($view = DEFAULT_VIEW, $subview = null, $contents = null) {
    $path = (__DIR__ . '/' . $view);
    if ($path) {
      if (!empty($subview)) {

        foreach (VIEW_EXTS as $ext) {
          $filename = $path . '/' . $subview . $ext;
          if (file_exists($filename)) {
            include_once($filename);
            exit;
          }
        }

      }

      // load base view if subview doesn't exists
      foreach (VIEW_FILENAMES as $name) {
        foreach (VIEW_EXTS as $ext) {
          $filename = $path . '/' . $name . $ext;
          if (file_exists($filename)) {
            include_once($filename);
            exit;
          }
        }
      }
    }
  }

  public function viewExists($view) {
    return is_dir(__DIR__ . '/' . $view);
  }

  public function error($message = null) {
    echo $this->helper->response(false, message: $message);
    exit;
  }

  private function callAndExit($prop, $method) {
    echo $prop->{$method}();
    exit;
  }

  public function canCallMethod($method) {
    // verify this
    if (method_exists($this, $method))
      $this->callAndExit($this, $method);

    // iterate properties
    foreach ($this as $prop) {
      if (method_exists($prop, $method)) {
        $this->callAndExit($prop, $method);
      }
    }

    // method not found
    $this->error();
  }

  private function say_hello() {
    echo $this->helper->response(true, message: 'Hello World!');
  }
}
