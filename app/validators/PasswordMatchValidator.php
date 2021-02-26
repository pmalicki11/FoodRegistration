<?php

  class PasswordMatchValidator {

    private $_field;
    private $_data1;
    private $_data2;
  
    public function __construct($field, $data1, $data2) {
      $this->_field = $field;
      $this->_data1 = $data1;
      $this->_data2 = $data2;
    }

    public function run() {
      return ($this->_data1 != $this->_data2) ? [$this->_field => 'Passwords must match'] : null;
    }
  }