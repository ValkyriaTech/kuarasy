<?php

require_once(dirname(__DIR__, 1) . '/controllers/Helper.php');
require_once(dirname(__DIR__, 1) . '/controllers/Default.php');
require_once(dirname(__DIR__, 1) . '/controllers/Upload.php');

class DefaultView {

  protected $helper;
  private $controller;
  private $upload;

  public function __construct() {
    $this->helper = new Helper();
    $this->controller = new DefaultController();
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
            break;
          }
        }

      } else {

        foreach (VIEW_FILENAMES as $name) {
          foreach (VIEW_EXTS as $ext) {
            $filename = $path . '/' . $name . $ext;
            if (file_exists($filename)) {
              include_once($filename);
              break;
            }
          }
        }

      }
    }
  }

  public function viewExists($view) {
    return is_dir(__DIR__ . '/' . $view);
  }

  public function checkStatus() {
    echo $this->controller->checkStatus();
  }

  public function error() {
    echo $this->helper->createMessage(false);
  }

  public function uploadFile() {
    echo $this->upload->uploadFile();
  }
}
