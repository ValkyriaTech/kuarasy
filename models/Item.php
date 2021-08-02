<?php

require_once(dirname(__DIR__, 1) . '/config.php');
require_once(dirname(__DIR__, 1) . '/controllers/Helper.php');

class Item {

  protected $helper;
  protected $conn;

  protected function __construct() {

    $this->helper = new Helper();
    try {
      $this->conn = new PDO('mysql:dbname=' . DB_NAME . '; host=localhost', DB_USER, DB_PASSWORD);

      if($this->conn){
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

    } catch (PDOException $e) {
      $msg = $e->getMessage();
      $this->helper->log->generateLog($msg);
    }

  }
}
