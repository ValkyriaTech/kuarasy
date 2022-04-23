<?php

class Cron {

  private $task;
  private $helper;

  public function __construct($task = null) {
    if (!empty($task)) {
      $this->task = $task;
    }
    $this->helper = new Helper();
  }

  public function execute() {
    switch ($this->task) {
      case 'say_hello':
        $this->helper->console->createMessage(0, 'Hello, World!');
        break;
    }
  }
}
