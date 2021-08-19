<?php

require_once(dirname(__DIR__, 1) . '/views/Console.php');

require_once('Log.php');
require_once('Encryption.php');

class Helper {

  public $log;
  public $encryption;
  public $console;

  public function __construct() {
    $this->log = new Log();
    $this->encryption = new Encryption();
    $this->console = new Console();
  }

  public function createMessage($status, $content = null, $msg = null) {

    $response = [
      'status' => $status,
      'content' => $content,
      'message' => $msg
    ];

    return json_encode((object) $response);
  }
}
