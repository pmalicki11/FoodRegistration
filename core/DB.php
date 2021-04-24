<?php

  class DB {

    private static $_instance = null;
    private $_pdo;


    private function __construct() {
      try {
        $this->_pdo = new PDO(
          'mysql:hostname='. DBHOST .';port=3306;dbname=' . DBNAME,
          DBUSER,
          DBPASSWORD,
          [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
        );
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
      $limit = '';
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
      
      if(isset($params['Limit'])) {
        $limit .= "LIMIT ";
        foreach($params['Limit'] as $value) {
          $limit .= $value . ', ';
          $bindingParams[] = $value;
        }
        $limit = rtrim($limit, ', ');
      }

      $query = $this->_pdo->prepare("SELECT {$columnString} FROM `{$table}` {$conditions} {$limit}");
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
      if($query->execute(array_values($params))) {
        $lastId = $this->_pdo->lastInsertId();
        return ($lastId != 0) ? $lastId : true;
      }
      return false;
    }


    public function update($table, $params) {
      $columnString = '';
      $conditions = '';
      $bindingParams = [];
      foreach($params['Columns'] as $column => $value) {
        $columnString .= "`{$column}`=?, ";
        $bindingParams[] = $value;
      }
      $columnString = rtrim($columnString, ', ');
      
      if(isset($params['Conditions'])) {
        foreach($params['Conditions'] as $column => $value) {
          $conditions .= "`{$column}`=? AND ";
          $bindingParams[] = $value;
        }
        $conditions = rtrim($conditions, ' AND ');
        if(strlen($conditions) > 0) {
          $conditions = ' WHERE ' . $conditions;
        }
      }

      $query = $this->_pdo->prepare("UPDATE `{$table}` SET {$columnString}{$conditions}");
      $query->execute($bindingParams);
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
