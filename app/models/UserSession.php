<?php 

  class UserSession {

    private $_id;
    public $userId;
    public $userAgent;
    private $_sessionId;

    public function __construct($user = null) {
      if($user) {
        $this->userId = $user->getId();
        $this->userAgent = Session::userAgentNoVersion();
        $this->_sessionId = md5(rand()) . md5(rand());
      }
    }

    public function setFromDatabase($data) {
      $this->_id = $data['id'];
      $this->userId = $data['user_id'];
      $this->userAgent = $data['user_agent'];
      $this->_sessionId = $data['session_id'];
    }

    public function getSessionId() {
      return $this->_sessionId;
    }
  }