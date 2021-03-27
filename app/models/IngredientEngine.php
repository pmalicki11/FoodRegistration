<?php

  class IngredientEngine {

    private $_db;
    private $_ingredient;
    private $_errors;

    public function __construct() {
      $this->_errors = [];
      $this->_db = DB::getInstance();
    }
    
    public function add($ingredient) {
      $this->_ingredient = $ingredient;
      if(!$this->_ingredientExists()) {
        return $this->_saveIngredient();
      }
      return false;
    }
    
    private function _ingredientExists() {
      $conditions = [];
      $conditions['name'] = ['=', $this->_ingredient->name];
      $result = $this->_db->select('ingredients', [
        'Columns' => ['*'],
        'Conditions' => $conditions
      ]);

      if(count($result) > 0) {
        $this->_errors = ['name' => 'Ingredient already exists'];
        return true;
      }
    }

    private function _saveIngredient() {
      $params = ['name' => $this->_ingredient->name];
      return $this->_db->insert('ingredients', $params);
    }

    public function getAll() {
      $result = $this->_db->select('ingredients', ['Columns' => ['*']]);
      $ingredientsList = [];
      foreach($result as $key => $value) {
        $ingredient = new Ingredient();
        $ingredient->setFromDatabase($value);
        array_push($ingredientsList, $ingredient);
      }
      return $ingredientsList;
    }

    public function getErrors() {
      return $this->_errors;
    }
  }