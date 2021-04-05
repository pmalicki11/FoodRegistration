<?php

  class ProductEngine {

    private $_db;
    private $_product;
    private $_errors;

    public function __construct() {
      $this->_errors = [];
      $this->_db = DB::getInstance();
    }


    public function add($product) {
      $this->_product = $product;
      if(!$this->_productExists()) {
        return $this->_saveProduct();
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