<?php

  class Authenticator {

    private $_db;
    private $_user;
    private $_userSession;
    private $_errors;

    public function __construct() {
      $this->_db = DB::getInstance();
    }

    public function loginUser($user) {
      $this->_user = $user;
      $givenPassword = $this->_user->password;
      
      $conditions['username'] = ['=', $this->_user->username];
      if($this->_loadUserData($conditions)
        && $this->_checkUserPassword($givenPassword)
        && $this->_isUserActive()
      ) {
        return true;
      }
      return false;
    } 
    
    private function _loadUserData($conditions) {
      $result = $this->_db->select('users', [
        'Columns' => ['*'],
        'Conditions' => $conditions
      ]);

      if(count($result) == 1) {
        $this->_user->setFromDatabase($result[0]);
        return true;
      }
      $this->_errors = ['Username' => 'User does not exist'];
      return false;
    }

    private function _checkUserPassword($password) {
      $password .= $this->_user->salt;
      $password = hash("sha256", $password);
      if($password == $this->_user->password) {
        return true;
      }
      $this->_errors = ['Password' => 'Wrong password'];
      return false;
    }
    
    private function _isUserActive() {
      if($this->_user->active) {
        return true;
      }
      $this->_errors = ['Username' => 'User is not active'];
      return true;
    }

    public function addUserSession($userSession) {
      $params = [
        'user_id' => $userSession->userId,
        'user_agent' => $userSession->userAgent,
        'session_id' => $userSession->getSessionId()
      ];
      $this->_db->insert('user_sessions', $params);
    }

    public function removeUserSession() {
      $params = ['Conditions' => [
        'user_id' => Session::currentUser()['id'],
        'user_agent' => Session::userAgentNoVersion()
      ]];
      $this->_db->delete('user_sessions', $params);
    }

    public function getErrors() {
      return $this->_errors;
    }
  }