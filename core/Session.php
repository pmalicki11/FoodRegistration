<?php

  class Session {

    public function __construct() {
      
    }

    public static function userAgentNoVersion() {
      $uagent = $_SERVER['HTTP_USER_AGENT'];
      $regx = '/\/[a-zA-Z0-9.]+/';
      $newString = preg_replace($regx, '', $uagent);
      return $newString;
    }

    public static function setUserSession($user) {
      $_SESSION['user'] = $user;
    }

    public static function currentUser() {
      return (isset($_SESSION['user'])) ? $_SESSION['user'] : null;
    }

    public static function getField($field) {
      return isset($_SESSION[$field]) ? $_SESSION[$field] : null;
    }

    public static function setField($fields) {
      foreach($fields as $field => $value) {
        $_SESSION[$field] = $value;
      }
    }

    public static function unsetField($field) {
      if(isset($_SESSION[$field])) {
        unset($_SESSION[$field]);
      }
    }
  }
