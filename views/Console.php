<?php

class Console {
  public function createMessage($level, $message) {
    $time = date('Y-m-d H:i:s');
    $ident = str_repeat('-', $level);

    echo '(' . $time . ') ' . (($level > 0) ? $ident . ' ' : '') . $message . PHP_EOL;
  }
}
