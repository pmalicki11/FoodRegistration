<?php

  class UserEngine {

    private $_db;

    public function __construct() {
      $this->_db = DB::getInstance();
    }

    public function getUserById($id) {
      $result = $this->_db->select('users', [
        'Columns' => ['*'],
        'Conditions' => ['id' => ['=', $id]]
      ]);

      if(count($result) == 1) {
        $user = new User();
        $user->setFromDatabase($result[0]);
        return $user;
      }
      return null;
    }

    public function getUserByName($userName) {
      $result = $this->_db->select('users', [
        'Columns' => ['*'],
        'Conditions' => ['username' => ['=', $userName]]
      ]);

      if(count($result) == 1) {
        $user = new User();
        $user->setFromDatabase($result[0]);
        return $user;
      }
      return null;
    }

  }
