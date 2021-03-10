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
      if(strlen($this->_data) < $this->_minLength) {
        if($this->_minLength == 1) {
          return [$this->_field => ucfirst($this->_field) . ' can\'t be empty'];
        }
        return [$this->_field => ucfirst($this->_field) . ' must be minimum ' . $this->_minLength . 'characters long'];
      } else if(strlen($this->_data) > $this->_maxLength) {
        return [$this->_field => ucfirst($this->_field) . ' must be maximum ' . $this->maxLength . 'characters long'];
      }
      return null;
    }
  }