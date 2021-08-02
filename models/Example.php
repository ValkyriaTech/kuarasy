<?php

require_once('Item.php');

class Example extends Item {

  private $id;
  private $field;

  public function __construct($id = null, $field = null) {
    parent::__construct();

    $this->id = $id;
    $this->field = $field;
  }

  public function save() {
    try {

      if(!empty($this->id))
        $stmt = $this->conn->prepare('UPDATE `example` SET `field` = :field WHERE `id` = :id;');
      else
        $stmt = $this->conn->prepare('INSERT INTO `example` (`field`) VALUES (:field);');

      if (!empty($this->id))
        $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':field', $this->field);

      if ($stmt->execute()) {
        $results = $stmt->rowCount();
        if ($results)
          return $results;
      } else
        $this->helper->log->generateLog('Error during EXAMPLE SAVE.');

    } catch (\Exception $e) {
      $this->helper->log->generateLog($e->getMessage());
    }
  }
}
