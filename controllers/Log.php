<?php
  class Log{

    private $logFilename;
    private $logData;

    public function __construct(){
      $this->logFilename = "log";

      if (!file_exists($this->logFilename))
        mkdir($this->logFilename, 0777, true);

      $this->logData = $this->logFilename .'/log_' . date('d-m-Y') . '.log';
    }

    public function generateLog($msg) {
      file_put_contents($this->logData, $msg . "\n", FILE_APPEND);
    }
  }
