<?php

require_once('Item.php');

class DefaultModel extends Item {

  public function __construct() {
    parent::__construct();
  }

  public function checkConnection() {
    if ($this->conn)
      return true;
    else
      return false;
  }
}
