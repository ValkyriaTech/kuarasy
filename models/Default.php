<?php

require_once('Item.php');

class DefaultModel extends Item {
  public function __construct() {}

  public function checkConnection() {
    parent::__construct();

    return (bool) $this->conn;
  }

  public function getMySqlVersion() {
    parent::__construct();

    if ($this->conn) {
      $stmt = $this->conn->prepare('SHOW VARIABLES LIKE "version"');

      if ($stmt->execute())
        return $stmt->fetch(PDO::FETCH_ASSOC);
      else
        $this->helper->log->generateLog('Error during SQL exec :(');
    }
  }
}
