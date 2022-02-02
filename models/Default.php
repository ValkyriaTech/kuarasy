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

  public function getMySqlVersion() {
    parent::__construct();

    if ($this->conn) {
      $stmt = $this->conn->prepare('SHOW VARIABLES LIKE "version"');

      if ($stmt->execute())
        return $stmt->fetch(PDO::FETCH_ASSOC);
      else
        $this->helper->log->generateLog('Error during SQL exec :(');
    }
  }

  /**
  * REQUIRES DefaultModel->tableName setted
  * Fetch multiple/single rows
  * @param array $fields String fields list: ['a', 'b']
  * @param array $where Array field/operation list: [['field'=>'id','operator'=>'=','value'=>8], ...]
  * @param bool $single Set true to fetch single row
  * @return array
  */
  public static function get($fields = null, $where = null, $single = false) {
    $obj = new DefaultModel();

    $stmt = $obj->statementQueryBuilder(
      // type
      'select',
      $fields,
      // where
      $where
    );

    if ($stmt->execute()) {

      if ($single)
        return $stmt->fetch(PDO::FETCH_ASSOC);
      else
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } else
        $obj->helper->log->generateLog('Error during SQL exec :(');
  }

  /**
  * REQUIRES DefaultModel->tableName setted
  * Delete one item by it's id
  * @param $id db item id
  * @return int
  */
  public static function delete($id) {
    $obj = new DefaultModel();

    $stmt = $obj->statementQueryBuilder(
      // type
      'delete',
      null,
      // where
      [
        [
          'field' => 'id',
          'operator' => '=', // =, <=, >=
          'value' => $id
        ]
      ]
    );

    if ($stmt->execute())
      return $stmt->rowCount();
    else
      $obj->helper->log->generateLog('Error during SQL exec :(');
  }
}
