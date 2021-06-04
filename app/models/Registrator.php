<?php

  class Registrator {

    private $_db;
    private $_errors;

    public function __construct() {
      $this->_db = DB::getInstance();
    }

    public function registerUser($user) {
      if(!$this->_userExists($user)) { 
        $user->salt = bin2hex(random_bytes(16));
        $user->password .= $user->salt;
        $user->password = hash("sha256", $user->password);
        $user->role = 'user';
        $user->active = md5(rand());
        if($this->_saveUser($user)) {
          $emailEngine = new EmailEngine();
          $emailEngine->sendRegistrationEmail($user);          
          return true;
        }
        return false;
      }
      return false;
    }

    private function _userExists($user) {
      $conditions = [];
      $conditions['username'] = ['=', $user->username];
      $result = $this->_db->select('users', [
        'Columns' => ['*'],
        'Conditions' => $conditions
      ]);

      if(count($result) > 0) {
        $this->_errors = ['username' => 'User already exists'];
        return true;
      }

      $conditions = [];
      $conditions['email'] = ['=', $user->email];
      $result = $this->_db->select('users', [
        'Columns' => ['*'],
        'Conditions' => $conditions
      ]);

      if(count($result) > 0) {
        $this->_errors = ['email' => 'Email is already used'];
        return true;
      }
      return false;
    }

    private function _saveUser($user) {
      $params = [
        'username' => $user->username,
        'password' => $user->password,
        'salt' => $user->salt,
        'email' => $user->email,
        'role' => $user->role,
        'active' => $user->active
      ];
      return $this->_db->insert('users', $params);
    }

    public function getErrors() {
      return $this->_errors;
    }
  }