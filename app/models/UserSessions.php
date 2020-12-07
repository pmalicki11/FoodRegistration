<?php

  class UserSessions {
    
    private $_id;
    private $_accountId;
    private $_userAgent;
    private $_sessionId;
    private $_db;

    public function __construct() {
      $this->_db = DB::getInstance();
    }
    
    public static function build() {
      $instance = new self();
      return $instance;
    }
    public function setId($id) {
      $this->_id = $id;
      return $this;
    }
    public function setAccountId($accountId) {
      $this->_accountId = $accountId;
      return $this;
    }
    public function setUserAgent($userAgent) {
      $this->_userAgent = $userAgent;
      return $this;
    }
    public function setSessionId($sessionId) {
      $this->_sessionId = $sessionId;
      return $this;
    }

    public function getAccountId() {
      return $this->_accountId;
    }

    public function loadBySessionId() {
      if(!empty($this->_sessionId))  {
        $conditions = [];
        $conditions['session_id'] = ['=', $this->_sessionId];
        if($this->load($conditions)) { return true; }
      }
      return false;
    }

    public function load($conditions) {     
      $result = $this->_db->select('user_sessions', [
        'Columns' => ['*'],
        'Conditions' => $conditions
      ]);

      if(count($result) == 1) {
        $result = $result[0];
        $this->_id = $result['id'];
        $this->_accountId = $result['account_id'];
        $this->_userAgent = $result['user_agent'];
        $this->_sessionId = $result['session_id'];
        return true;
      }
      return false;
    }


    public function add() {
      $params = [
        'account_id' => $this->_accountId,
        'user_agent' => $this->_userAgent,
        'session_id' => $this->_sessionId
      ];
      $this->_db->insert('user_sessions', $params);
    }

    public function remove() {
      $params = ['Conditions' => [
        'account_id' => $this->_accountId,
        'user_agent' => $this->_userAgent
      ]];
      $this->_db->delete('user_sessions', $params);
    }

    public static function userAgentNoVersion() {
      $uagent = $_SERVER['HTTP_USER_AGENT'];
      $regx = '/\/[a-zA-Z0-9.]+/';
      $newString = preg_replace($regx, '', $uagent);
      return $newString;
    }
  }