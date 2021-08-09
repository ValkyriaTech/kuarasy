<?php

class Cron {

  private $task;
  private $key;

  public function __construct($task = null, $key = null) {
    if (!empty($task) && !empty($key)) {
      $this->task = $task;
      $this->key = $key;
    }
  }

  public function execute() {
    if ($this->task == 'say_hello' && $this->key == SAY_HELLO) {
      echo 'Task: Hello, World!';
    }
  }
}
