<?php

require_once(dirname(__DIR__, 1) . '/config.php');
require_once(dirname(__DIR__, 1) . '/controllers/Helper.php');

class Item {

  protected $helper;
  protected $conn;
  protected $tableName;

  protected function __construct() {

    $this->helper = new Helper();
    try {
      $this->conn = new PDO('mysql:dbname=' . K_DB_NAME . '; host=localhost', K_DB_USER, K_DB_PASSWORD);

      if ($this->conn) {
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

    } catch (PDOException $e) {
      $msg = $e->getMessage();
      $this->helper->log->generateLog($msg);
    }

  }

  // OBS: tableName is required
  protected function statementQueryBuilder($type, $fields = null, $where = null) {
    if (!empty($this->tableName)) {
      $query = '';
      $params = [];

      switch (strtolower($type)) {
        case 'insert':
          $query = 'INSERT INTO `' . $this->tableName . '` (';
          $queryPart = ' VALUES (';
          if (!empty($fields)) {
            $i = 0;
            foreach ($fields as $field => $value) {

              $query .= '`' . $field . '`';
              $queryPart .= ':' . $field . '';
              if ($i != (count($fields) - 1)) {
                $query .= ', ';
                $queryPart .= ', ';
              } else {
                $query .= ')';
                $queryPart .= ')';
              }

              // params for bind
              $params[':' . $field] = $value;

              $i++;
            }
          }
          $query .= $queryPart;
          break;

        case 'update':
          $query .= 'UPDATE `' . $this->tableName . '` SET ';

          $i = 0;
          foreach ($fields as $field => $value) {

            $query .= '`' . $field . '` = :' . $field;
            if ($i != (count($fields) - 1))
              $query .= ', ';

            // params for bind
            $params[':' . $field] = $value;

            $i++;
          }
          break;

        case 'delete':
          $query = 'DELETE FROM `' . $this->tableName . '`';
          break;

        default:
          $fieldsToQuery = '';
          if (!empty($fields)) {
            for ($i=0; $i < count($fields); $i++) {

              $fieldsToQuery .= '`' . $fields[$i] . '`';
              if ($i != (count($fields) - 1))
                $fieldsToQuery .= ', ';

            }
          } else {
            $fieldsToQuery = '*';
          }

          $query = 'SELECT ' . $fieldsToQuery . ' FROM `' . $this->tableName . '`';
          break;
      }

      // === WHERE ===
      if (!empty($where)) {
        $query .= ' WHERE';

        $i = 0;
        foreach ($where as $fieldData) {

          // query string
          $query .= ' `' . $fieldData['field'] . '` ' . $fieldData['operator'] . ' :' . $fieldData['field'] . '';
          if ($i != (count($where) - 1))
            $query .= ' AND';

          // params for bind
          $params[':' . $fieldData['field']] = $fieldData['value'];

          $i++;
        }
      }

      $stmt = $this->conn->prepare($query);

      // params binding
      foreach ($params as $p => $value) {
        $stmt->bindValue($p, $value);
      }

      return $stmt;
    }
  }

  protected function getLastInsertId() {
    return $this->conn->lastInsertId();
  }

  /**
  * REQUIRES DefaultModel->tableName setted
  * Fetch multiple/single rows
  * @param array $fields String fields list: ['a', 'b']
  * @param array $where Array field/operation list: [['field'=>'id','operator'=>'=','value'=>8], ...]
  * @param bool $single Set true to fetch single row
  * @return array
  */
  protected function getDefault($fields = null, $where = null, $single = false) {
    $stmt = $this->statementQueryBuilder(
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
        $this->helper->log->generateLog('Error during SQL exec :(');
  }

  /**
  * REQUIRES DefaultModel->tableName setted
  * Delete one item by it's id
  * @param $id db item id
  * @return int
  */
  protected function deleteDefault($id) {
    $stmt = $this->statementQueryBuilder(
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
      $this->helper->log->generateLog('Error during SQL exec :(');
  }

  /**
  * REQUIRES DefaultModel->tableName setted
  * Insert or update row
  * @param array $fields String fields list: ['a', 'b']
  * @param array $where Array field/operation list: [['field'=>'id','operator'=>'=','value'=>8], ...]
  * @return int
  */
  protected function saveDefault($fields, $where = null) {
    if (empty($where))
      $stmt = $this->statementQueryBuilder(
        'insert',
        $fields
      );
    else
      $stmt = $this->statementQueryBuilder(
        'update',
        $fields,
        $where
      );

    if ($stmt->execute())
      return $stmt->rowCount();
    else
      $this->helper->log->generateLog('Error during SQL exec :(');
  }
}
