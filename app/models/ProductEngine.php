<?php

  class ProductEngine {

    private $_db;
    private $_product;
    private $_ingredients;
    private $_errors;

    public function __construct() {
      $this->_errors = [];
      $this->_ingredients = [];
      $this->_db = DB::getInstance();
    }


    public function add($product, $ingredients) {
      $this->_product = $product;
      $this->_ingredients = $ingredients;
      if(!$this->_productExists() && $this->_hasIngredients()) {
        if($productId = $this->_saveProduct()) {
          return $this->_saveProductIngredients($productId);
        }
      }
      return false;
    }

    public function edit($product) {
      //TODO
    }

    private function _productExists() {
      $conditions = [];
      $conditions['name'] = ['=', $this->_product->name];
      $result = $this->_db->select('products', [
        'Columns' => ['*'],
        'Conditions' => $conditions
      ]);

      if(count($result) > 0) {
        $this->_errors = ['name' => 'Product already exists'];
        return true;
      }
    }

    private function _hasIngredients() {
      if(count($this->_ingredients) == 0) {
        $this->_errors = ['ingredients' => 'Product must contain at least one ingredient'];
        return false;
      }
      return true;
    }

    private function _saveProduct() {
      $params = [
        'name' => $this->_product->name,
        'producer' => $this->_product->producer,
        'portion' => $this->_product->portion,
        'energy' => $this->_product->energy,
        'fat' => $this->_product->fat,
        'carbohydrates' => $this->_product->carbohydrates,
        'protein' => $this->_product->protein
      ];
      return $this->_db->insert('products', $params);
    }

    private function _saveProductIngredients($productId) {
      $result = true;
      foreach($this->_ingredients as $ingredient) {
        $params = [
          'product_id' => $productId,
          'ingredient_id' => $ingredient->getId()
        ];
        $result = ($result && $this->_db->insert('product_ingredients', $params));
      }
      return $result;
    }

    public function getAll() {
      $result = $this->_db->select('products', ['Columns' => ['*']]);
      $productsList = [];
      foreach($result as $key => $value) {
        $product = new Product();
        $product->setFromDatabase($value);
        array_push($productsList, $product);
      }
      return $productsList;
    }

    public function getById($id) {
      $result = $this->_db->select('products',[
        'Columns' => ['*'],
        'Conditions' => ['id' => ['=', $id]]
      ]);

      if(count($result) == 1) {
        $result = $result[0];
        $product = new Product();
        $product->setFromDatabase($result);
        return $product;
      }
      return null;
    }

    public function delete($id) {      
      $params = ['Conditions' => ['id' => $id]];
      $this->_db->delete('products', $params);
    }

    public function getErrors() {
      return $this->_errors;
    }

  }