<?php

require_once(dirname(__DIR__, 1) . '/config.php');
require_once('Helper.php');

class UploadController {

  private $helper;

  public function __construct() {
    $this->helper = new Helper();

    if (!file_exists('uploads'))
      mkdir('uploads', 0777, true);
  }

  public function uploadImage() {
    if ($this->helper->authenticateUsername()) {
      $attachment = $_FILES['file'];

      $supportedTypes = ['image/png', 'image/jpg', 'image/jpeg'];
      if (in_array($attachment['type'], $supportedTypes)) {
        // check if is real image
        if (getimagesize($attachment['tmp_name'])) {

          $ext = strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION));
          $filename = basename(bin2hex(random_bytes(8)) . '.' . $ext);
          $targetFile = UPLOADS_DIR . $filename;
          if (file_exists($targetFile)) {
            $filename = basename(bin2hex(random_bytes(8)) . '.' . $ext);
            $targetFile = UPLOADS_DIR . $filename;
          }

          if (move_uploaded_file($attachment['tmp_name'], $targetFile)) {

            $content = (object) [
              'file_path' => $filename
            ];
            echo $this->helper->createMessage(true, $content, 'File sent!');

          }
        }
      } else {
        echo $this->helper->createMessage(false, null, 'File extension not supported!');
      }
    }
  }
}
