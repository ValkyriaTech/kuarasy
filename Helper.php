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

  public function response($status, $content = null, $message = null) {

    $response = (object) [
      'status' => $status,
      'content' => $content,
      'message' => $message
    ];

    header('Content-Type: application/json; charset=utf-8');
    return json_encode((object) $response);
  }

  /**
  * returns a string from a loaded template file, located in /templates
  * @param string $type String file template name (located in /templates)
  * @param array $where Array template args
  * @return string
  */
  public function renderPhp($template, array $args) {

    $basePath = '';
    if (str_contains($template, '/')) {
      $templateData = explode('/', $template);
      $template = $templateData[count($templateData) - 1];
      $templateData[count($templateData) - 1] = '';

      $basePath = implode('/', $templateData);
    }

    $path = './templates/' . $basePath;
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
