<?php

class Log{

  private $logFilename;
  private $logData;

  public function __construct() {
    $this->logFilename = 'log';

    if (!file_exists($this->logFilename))
      mkdir($this->logFilename, 0777, true);

    $this->logData = $this->logFilename . '/' . date('Y-m-d') . '.log';
  }

  public function generateLog($msg) {
    $time = date('Y-m-d H:i:s');
    file_put_contents($this->logData, '(' . $time . ') ' . $msg . "\n", FILE_APPEND);
  }
}
