<?php

require_once('./views/Console.php');
require_once('./controllers/Log.php');

class Helper {

  public $log;
  public $console;

  public function __construct() {
    $this->log = new Log();
    $this->console = new Console();
  }

  public function createMessage($status, $content = null, $msg = null) {

    $response = [
      'status' => $status,
      'content' => $content,
      'message' => $msg
    ];

    header('Content-Type: application/json; charset=utf-8');
    return json_encode((object) $response);
  }

  // returns a string from a loaded template file, located in /templates
  public function renderPhp($template, array $args) {

    $basePath = '';
    if (str_contains($template, '/')) {
      $templateData = explode('/', $template);
      $template = $templateData[count($templateData) - 1];
      $templateData[count($templateData) - 1] = '';

      $basePath = implode('/', $templateData);
    }

    $path = dirname(__DIR__, 1) . '/templates/' . $basePath;
    if ($path) {

      $files = scandir($path);
      foreach ($files as $key => $value) {
        if (str_contains($value, $template)) {

          ob_start();
          include_once($path . $value);
          $content = ob_get_contents();
          ob_end_clean();

          return $content;
        }
      }
    }
  }
}
