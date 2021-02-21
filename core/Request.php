<?php

  class Request {

    public function __construct() {
    }

    public function isEmpty() {
      return empty($_REQUEST);
    }

    public function __get($field) {
      return isset($_REQUEST[$field]) ? $_REQUEST[$field] : null;
    }
  }