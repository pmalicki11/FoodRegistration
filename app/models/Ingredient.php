<?php

class Ingredient {

  private $_id;
  public $name;
  private $_validators = [];

  public function __construct() {
  }

  public function getId() {
    return $this->_id;
  }

  public function setFromRequest() {
    $this->_id = Request::get('id');
    $this->name = Request::get('name');
  }

  public function setFromDatabase($data) {
    $this->_id = $data['id'];
    $this->name = $data['name'];
  }

  public function validate() {
    $this->_validators[] = new LengthValidator('name', $this->name, 2, 50);
    $errors = [];
    foreach($this->_validators as $validator) {
      if($validator->run()) {
        $errors = array_merge($errors, $validator->run()); 
      }
    }
    return $errors;
  }

  public function toArray() {
    return [
      'id' => $this->_id,
      'name' => $this->name
    ];
  }
}
