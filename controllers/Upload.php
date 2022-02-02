<?php

require_once(dirname(__DIR__, 1) . '/config.php');
require_once('Helper.php');

class UploadController {

  private $helper;

  public function __construct() {
    $this->helper = new Helper();

    if (!file_exists(UPLOADS_DIR))
      mkdir(UPLOADS_DIR, 0777, true);
  }

  public function uploadImage() {
    $directoryName = UPLOADS_DIR . date('Y') . '/' . date('m');
    if (!file_exists($directoryName))
      mkdir($directoryName, 0777, true);

    $attachment = $_FILES['file'];

    $supportedTypes = ['image/png', 'image/jpg', 'image/jpeg'];
    if (in_array($attachment['type'], $supportedTypes)) {
      // check if is real image
      if (getimagesize($attachment['tmp_name'])) {

        $ext = strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION));
        $filename = basename(bin2hex(random_bytes(16)) . '.' . $ext);
        $targetFile = $directoryName . '/' . $filename;

        if (move_uploaded_file($attachment['tmp_name'], $targetFile)) {

          $content = (object) [
            'file_path' => $filename
          ];
          return $this->helper->createMessage(true, $content, 'File sent!');

        }
      }
    } else
        return $this->helper->createMessage(false, null, 'File extension not supported!');
  }
}
