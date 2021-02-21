<?php

  class Cookie {

    public static function setRememberCookie($value) {
      setcookie(REMEMBER_ME_COOKIE_NAME, $value, time() + COOKIE_DURABILITY, PROOT);
    }

    public static function deleteRememberCookie() {
      setcookie(REMEMBER_ME_COOKIE_NAME, '', time() - 3600, PROOT);
    }
  }