<?php

  class EmailValidator {

    private $_field;
    private $_email;
  
    public function __construct($field, $email) {
      $this->_field = $field;
      $this->_email = $email;
    }

    public function run() {
      return (!filter_var($this->_email, FILTER_VALIDATE_EMAIL)) ? [$this->_field => 'Wrong email address'] : null;
    }
  }