<?php

require_once('Item.php');

class DefaultModel extends Item {

  public function __construct() {}

  public function checkConnection() {
    parent::__construct();

    if ($this->conn)
      return true;
    else
      return false;
  }
}
