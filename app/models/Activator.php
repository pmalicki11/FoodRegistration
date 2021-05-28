<?php

  class Activator {

    private $_db;
    private $_errors;
    private $_token;

    public function __construct($token) {
      $this->_db = DB::getInstance();
      $this->_errors = [];
      $this->_token = $token;
    }


    public function activateAccount() {
      $user = new User();
      $user = $this->_getUserData();
      if($user != null) {
        /*
          User found
          1. Change active to 1
          2. Send confirmation email
          3. Redirect to login page
        */
      } else {
        $this->_errors = array_merge($this->_errors, ['general' => 'Bad token.']);
      }
    }


    private function _getUserData() {
      $conditions['active'] = ['=', $this->_token];
      $result = $this->_db->select('users', [
        'Columns' => ['*'],
        'Conditions' => $conditions
      ]);
      
      if(count($result) == 1) {
        $user = new User();
        $user->setFromDatabase($result[0]);
        return $user;
      }
      return null;
    }


    public function getErrors() {
      return $this->_errors;
    }

  }