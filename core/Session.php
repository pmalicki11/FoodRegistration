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
      $_SESSION['user'] = $user->toArray();
    }

    public static function currentUser() {
      return (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
    }
  }