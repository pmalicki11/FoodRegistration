<?php

  class DB {

    private static $_instance = null;
    private $_pdo;


    private function __construct() {
      try {
        $this->_pdo = new PDO('mysql:host='. DBHOST .';dbname=' . DBNAME, DBUSER, DBPASSWORD);
      } catch (PDOException $e) {
        die($e->getMessage());
      }
    }


    public static function getInstance() {
      if(!isset(self::$_instance)) {
        self::$_instance = new self();
      }
      return self::$_instance;
    }


    public function select($table, $params) {
      $columnString = '';
      $conditions = '';
      $bindingParams = [];
      foreach($params['Columns'] as $column) {
        if($column == '*') {
          $columnString .= $column;
          break;
        } else {
          $columnString .= "`{$column}`,";
        }
      }
      $columnString = rtrim($columnString, ',');
      if(isset($params['Conditions'])) {
        foreach($params['Conditions'] as $column => $value) {
          $conditions .= "`{$column}` {$value[0]} ? AND ";
          $bindingParams[] = $value[1];
        }
        $conditions = rtrim($conditions, ' AND ');
        if(strlen($conditions) > 0) {
          $conditions = ' WHERE ' . $conditions;
        }
      }

      $query = $this->_pdo->prepare("SELECT {$columnString} FROM `{$table}` {$conditions}");
      $query->execute($bindingParams);
      $result = $query->fetchAll(PDO::FETCH_NAMED);
      return $result;
    }


    public function insert($table, $params) {
      $columnString = '';
      $valueString = '';
      foreach($params as $column => $value) {
        $columnString .= "`{$column}`,";
        $valueString .= "?,";
      }
      $columnString = rtrim($columnString, ',');
      $valueString = rtrim($valueString, ',');
      $query = $this->_pdo->prepare("INSERT INTO `{$table}` ({$columnString}) VALUES ({$valueString})");
      $query->execute(array_values($params));
    }


    public function delete($table, $params) {
      $conditions = '';
      foreach($params['Conditions'] as $column => $value) {
        $conditions .= "`{$column}`=? AND ";
      }
      $conditions = rtrim($conditions, ' AND ');
      $query = $this->_pdo->prepare("DELETE FROM `{$table}` WHERE {$conditions}");
      return $query->execute(array_values($params['Conditions']));
    }


    public function getColumns($table) {
      $query = $this->_pdo->prepare("DESCRIBE `{$table}`");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_COLUMN);
    }
  }
