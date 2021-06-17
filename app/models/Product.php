<?php

class Product {

  private $_id;
  public $name;
  public $producer;
  public $portion;
  public $energy;
  public $fat;
  public $carbohydrates;
  public $protein;
  private $_validators = [];

  public function __construct() {
  }

  public function getId() {
    return $this->_id;
  }

  public function setFromRequest() {
    $this->_id = Request::get('id');
    $this->name = Request::get('name');
    $this->producer = Request::get('producer');
    $this->portion = Request::get('portion');
    $this->energy = Request::get('energy');
    $this->fat = Request::get('fat');
    $this->carbohydrates = Request::get('carbohydrates');
    $this->protein = Request::get('protein');
  }

  public function setFromDatabase($data) {
    $this->_id = $data['id'];
    $this->name = $data['name'];
    $this->producer = $data['producer'];
    $this->portion = $data['portion'];
    $this->energy = $data['energy'];
    $this->fat = $data['fat'];
    $this->carbohydrates = $data['carbohydrates'];
    $this->protein = $data['protein'];
  }

  public function validate() {
    $this->_validators[] = new LengthValidator('name', $this->name, 2, 150);
    $this->_validators[] = new LengthValidator('producer', $this->producer, 2, 50);

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
      'name' => $this->name,
      'producer' => $this->producer,
      'portion' => $this->portion,
      'energy' => $this->energy,
      'fat' => $this->fat,
      'carbohydrates' => $this->carbohydrates,
      'protein' => $this->protein
    ];
  }

  public function nutritionInfo() {
    return [
      'producer' => $this->producer,
      'portion' => $this->portion,
      'energy' => $this->energy,
      'fat' => $this->fat,
      'carbohydrates' => $this->carbohydrates,
      'protein' => $this->protein
    ];
  }

}