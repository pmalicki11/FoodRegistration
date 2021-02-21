<?php 

  class UserSession {

    private $_id;
    public $userId;
    public $userAgent;
    private $_sessionId;

    public function __construct($user) {
      $this->userId = $user->getId();
      $this->userAgent = Session::userAgentNoVersion();
      $this->_sessionId = md5(rand()) . md5(rand());
    }

    public function getSessionId() {
      return $this->_sessionId;
    }
  }