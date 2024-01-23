<?php

  class LengthValidator {

    private $_field;
    private $_data;
    private $_minLength;
    private $_maxLength;

    public function __construct($field, $data, $minLength, $maxLength) {
      $this->_field = $field;
      $this->_data = $data;
      $this->_minLength = $minLength;
      $this->_maxLength = $maxLength;
    }

    public function run() {
      if($result = $this->_checkEmpty()) {
        return $result;
      }
      if(strlen($this->_data) < $this->_minLength) {
        return [$this->_field => ucfirst($this->_field) . ' must be minimum ' . $this->_minLength . ' characters long'];
      }
      if(strlen($this->_data) > $this->_maxLength) {
        return [$this->_field => ucfirst($this->_field) . ' must be maximum ' . $this->_maxLength . ' characters long'];
      }
      return null;
    }

    private function _checkEmpty() {
      if($this->_minLength > 0 && strlen($this->_data ?? '') == 0) {
        return [$this->_field => ucfirst($this->_field) . ' can not be empty'];
      }
      return null;
    }
  }