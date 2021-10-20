<?php

  class APIRequest {
        
    private $_object;
    private $_method;
    private $_params;

    public function __construct($object, $method) {
      $this->_object = $object;
      $this->_method = $method;
    }

    public function call($params) {
      $object = new $this->_object();
      $this->_params = $params;
      $objectMethod = [$object, $this->_method];

      if(is_callable($objectMethod)) {
        $response = call_user_func($objectMethod, $params);
        http_response_code($response['status']);
        return $response['message'];

      } else {
        http_response_code(ResponseStatus::badRequest);
        die();
      }
    }

    public static function authenticate() {
      $passed = true;
      if($passed) {
        return true; // todo
      }
    }
  }
