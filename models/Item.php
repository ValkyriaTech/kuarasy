<?php

require_once(dirname(__DIR__, 1) . '/config.php');
require_once(dirname(__DIR__, 1) . '/controllers/Helper.php');

abstract class Item {

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
}
