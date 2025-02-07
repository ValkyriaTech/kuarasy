<?php

class BaseModel {

  protected $helper;
  protected $conn;
  protected $tableName;

  public function __construct() {
    $this->helper = new Helper();
  }

  /**
  * Connect to database using PDO layer. MUST be calld before using any other method from this class
  */
  protected function connect() {
    try {
      $this->conn = new PDO(K_DB_DRIVER . ':dbname=' . K_DB_NAME . '; host=' . K_DB_HOST, K_DB_USER, K_DB_PASSWORD);

      if ($this->conn) {
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

    } catch (PDOException $e) {
      $this->helper->log->generateLog($e->getMessage());
    }
  }

  /**
  * Create statement query
  * OBS: Specify tableName if isn't already defined
  * @param string $type Query type (select, insert, update, etc)
  * @param array $fields String fields list: ['a', 'b']
  * @param array $where Array field/operation list: [['field'=>'id','operator'=>'=','value'=>8], ...]
  * @return PDOStatement
  */
  protected function statementQueryBuilder($type, $fields = null, $where = null, $tableName = null) {
    $this->connect();

    if (!empty($tableName))
      $this->tableName = $tableName;

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

  /**
  * Fetch multiple/single rows
  * OBS: Specify tableName if isn't already defined
  * @param array $fields String fields list: ['a', 'b']
  * @param array $where Array field/operation list: [['field'=>'id','operator'=>'=','value'=>8], ...]
  * @param bool $single Set true to fetch single row
  * @return array
  */
  protected function get($fields = null, $where = null, $single = false, $tableName = null) {
    $this->connect();

    if (!empty($tableName))
      $this->tableName = $tableName;

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
        $this->helper->log->generateLog('Error during SQL exec.');
  }

  /**
  * Insert or update row
  * OBS: Specify tableName if isn't already defined
  * @param array $fields String fields list: ['a', 'b']
  * @param array $where Array field/operation list: [['field'=>'id','operator'=>'=','value'=>8], ...]
  * @return int
  */
  protected function save($fields, $where = null, $tableName = null) {
    $this->connect();

    if (!empty($tableName))
      $this->tableName = $tableName;

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
      $this->helper->log->generateLog('Error during SQL exec.');
  }

  /**
  * @return numeric
  */
  protected function getLastInsertId() {
    $this->connect();

    return $this->conn->lastInsertId();
  }

  /**
  * Delete one item by it's id
  * OBS: Specify tableName if isn't already defined
  * @param $id db item id
  * @return int
  */
  protected function delete($id, $tableName = null) {
    $this->connect();

    if (!empty($tableName))
      $this->tableName = $tableName;

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
      $this->helper->log->generateLog('Error during SQL exec.');
  }

  public function checkDbConnection() {
    $this->connect();

    return (bool) $this->conn;
  }

  public function getMySqlVersion() {
    $this->connect();

    if ($this->conn) {
      $stmt = $this->conn->prepare('SHOW VARIABLES LIKE "version"');

      if ($stmt->execute())
        return $stmt->fetch(PDO::FETCH_ASSOC);
      else
        $this->helper->log->generateLog('Error during SQL exec.');
    }
  }
}
