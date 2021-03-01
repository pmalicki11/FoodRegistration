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
      $result = null;

      if(strlen($this->_data) < $this->_minLength)
        $result = [$this->_field => $this->_field . ' must be minimum ' . $this->_minLength . 'characters long'];

      if(strlen($this->_data) > $this->_maxLength)
        $result = [$this->_field => $this->_field . ' must be maximum ' . $this->maxLength . 'characters long'];
  
      return $result;
    }
  }