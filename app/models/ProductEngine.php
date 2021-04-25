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

    public function edit($product, $ingredients) {
      // check if name exists in database for other ingredient
      // SELECT * FROM ingredients WHERE id != $id AND name = $name
      $result = $this->_db->select('products',[
        'Columns' => ['*'],
        'Conditions' => [
          'id' => ['!=', $product->getId()],
          'name' => ['=', $product->name]
        ]
      ]);

      if(count($result) > 0) {
        $this->_errors = ['name' => 'Ingredient already exists'];
        return false;
      }

      // Update products table
      $this->_db->update('products', [
        'Columns' => [
          'name' => $product->name,
          'producer' => $product->producer,
          'portion' => $product->portion,
          'energy' => $product->energy,
          'fat' => $product->fat,
          'carbohydrates' => $product->carbohydrates,
          'protein' => $product->protein
        ],
        'Conditions' => ['id' => $product->getId()]
      ]);


      return true;
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

    public function getByIngredientId($id) {
      $result = $this->_db->select('product_ingredients',[
        'Columns' => ['*'],
        'Conditions' => ['ingredient_id' => ['=', $id]]
      ]);
      
      $productsList = [];
      if(count($result) > 0) {
        foreach($result as $key => $value) {
          $product = $this->getById($value['product_id']);
          array_push($productsList, $product);
        }
        return $productsList;
      }
      return null;
    }

    public function delete($id) {      
      $params = ['Conditions' => ['id' => $id]];
      if($this->_db->delete('products', $params)) {
        $this->_deleteProductIngredients($id);
      }
    }

    private function _deleteProductIngredients($productId) {
      $params = ['Conditions' => ['product_id' => $productId]];
      $this->_db->delete('product_ingredients', $params);
    }

    public function getErrors() {
      return $this->_errors;
    }

  }