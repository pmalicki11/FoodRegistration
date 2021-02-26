<?php

  class Request {

    public function __construct() {
    }

    public static function isEmpty() {
      return empty($_REQUEST);
    }

    public static function get($field) {
      return isset($_REQUEST[$field]) ? $_REQUEST[$field] : null;
    }
  }