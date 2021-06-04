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
        $this->_setUserActive($user);
        $emailEngine = new EmailEngine();
        $emailEngine->sendActivationEmail($user);
        return true;
      } else {
        $this->_errors = array_merge($this->_errors, ['general' => 'Bad token. Account activation failed']);
        return false;
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

    private function _setUserActive($user) {
      $params = [
        'Columns' => ['active' => 1],
        'Conditions' => ['id' => $user->getId()]
      ];
      $this->_db->update('users', $params);
    }


    public function getErrors() {
      return $this->_errors;
    }

  }