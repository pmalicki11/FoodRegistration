<?php

  class Cookie {

    public static function setRememberCookie($value) {
      setcookie(REMEMBER_ME_COOKIE_NAME, $value, time() + COOKIE_DURABILITY, PROOT);
    }

    public static function deleteRememberCookie() {
      setcookie(REMEMBER_ME_COOKIE_NAME, '', time() - 3600, PROOT);
    }

    public static function setJWTCookie($value) {
      setcookie('JWT', $value, time() + COOKIE_DURABILITY, PROOT);
    }

    public static function deleteJWTCookie() {
      setcookie('JWT', '', time() - 3600 , PROOT);
    }

    public static function getCookie($cookieName) {
      return isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : null;
    }
  }
