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

    public function edit($ingredient) {
      // check if name exists in database for other ingredient
      // SELECT * FROM ingredients WHERE id != $id AND name = $name
      $result = $this->_db->select('ingredients',[
        'Columns' => ['*'],
        'Conditions' => [
          'id' => ['!=', $ingredient->getId()],
          'name' => ['=', $ingredient->name]
        ]
      ]);
      
      if(count($result) > 0) {
        $this->_errors = ['name' => 'Ingredient already exists'];
        return false;
      }
      
      // Update
      $this->_db->update('ingredients', [
        'Columns' => ['name' => $ingredient->name],
        'Conditions' => ['id' => $ingredient->getId()]
      ]);

      return true;  
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

    public function getAllForProduct($productId) {
      $ingredientIds = $this->_db->select('product_ingredients', [
        'Columns' => ['ingredient_id'],
        'Conditions' => ['product_id' => ['=', $productId]]
      ]);

      $ingredientsList = [];
      foreach($ingredientIds as $value) {
        $ingredientId = $value['ingredient_id'];
        $ingredient = $this->getById($ingredientId);
        array_push($ingredientsList, $ingredient);
      }
      return $ingredientsList;
    }

    public function getById($id) {
      $result = $this->_db->select('ingredients',[
        'Columns' => ['*'],
        'Conditions' => ['id' => ['=', $id]]
      ]);

      if(count($result) == 1) {
        $result = $result[0];
        $ingredient = new Ingredient();
        $ingredient->setFromDatabase($result);
        return $ingredient;
      }
      return null;
    }

    public function getByName($name) {
      $compareType = strpos($name, '%') ? 'LIKE' : '=';
      $results = $this->_db->select('ingredients',[
        'Columns' => ['*'],
        'Conditions' => ['name' => [$compareType, $name]]
      ]);

      if(count($results) > 0) {
        $ingredientsList = [];
        foreach($results as $result) {
          $ingredient = new Ingredient();
          $ingredient->setFromDatabase($result);
          array_push($ingredientsList, $ingredient);
        }
        return $ingredientsList;
      }
      return null;
    }

    public function delete($id) {      
      $params = ['Conditions' => ['id' => $id]];
      $this->_db->delete('ingredients', $params);
    }

    public function getErrors() {
      return $this->_errors;
    }
  }