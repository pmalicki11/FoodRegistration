<?php

  class APIRequest {
        
    private $_object;
    private $_method;
    private $_params;
    private $_path;

    public function __construct($object, $method) {
      $this->_object = ucfirst($object);
      $this->_method = $method;
      $this->_path = $object . '/' . $method;
    }

    public function call($params) {
      $object = new $this->_object();
      $this->_params = $params;
      $objectMethod = [$object, $this->_method];

      if(!is_callable($objectMethod)) {
        http_response_code(ResponseStatus::badRequest);

      } elseif(!Router::checkAccess(Session::currentUser(), $this->_path)) {
        http_response_code(ResponseStatus::unauthorized);

      } else { 
        $response = call_user_func($objectMethod, $params);
        http_response_code($response['status']);
        return $response['message'];
      }
  }
}
