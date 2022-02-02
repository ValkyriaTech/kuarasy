<?php

require_once('Item.php');

class DefaultModel extends Item {

  public function __construct($tableName = null) {
    if (!empty($tableName))
      $this->tableName = $tableName;
  }

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
      'select',
      $fields,
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
      'delete',
      null,
      [
        [
          'field' => 'id',
          'operator' => '=',
          'value' => $id
        ]
      ]
    );

    if ($stmt->execute())
      return $stmt->rowCount();
    else
      $obj->helper->log->generateLog('Error during SQL exec :(');
  }

  /**
  * REQUIRES DefaultModel->tableName setted
  * Insert or update row
  * @param array $fields String fields list: ['a', 'b']
  * @param array $where Array field/operation list: [['field'=>'id','operator'=>'=','value'=>8], ...]
  * @return int
  */
  public static function save($fields = null, $where = null) {
    $obj = new DefaultModel();

    if (empty($where))
      $stmt = $obj->statementQueryBuilder(
        'insert',
        $fields
      );
    else
      $stmt = $obj->statementQueryBuilder(
        'update',
        $fields,
        $where
      );

    if ($stmt->execute())
      return $stmt->rowCount();
    else
      $obj->helper->log->generateLog('Error during SQL exec :(');
  }
}
