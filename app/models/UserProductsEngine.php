<?php

  class UserProductsEngine {

    private $_errors;
    private $_db;

    public function __construct() {
      $this->_db = DB::getInstance();
    }

    public function assign($userId, $productId, $symptoms) {
      if($this->isProductAssignedToUser($productId, $userId)) {
        return false;
      }

      $params = [
        'user_id' => $userId,
        'product_id' => $productId,
        'symptoms' => $symptoms
      ];

      if($this->_db->insert('user_products', $params)) {
        return true;
      }
      return false;
    }

    public function isProductAssignedToUser($productId, $userId) {
      $result = $this->_db->select('user_products', [
        'Columns' => ['*'],
        'Conditions' => [
          'product_id' => ['=', $productId],
          'user_id' => ['=', $userId]
        ]
      ]);

      if(empty($result)) {
        return false;
      }
      $this->_errors[] = 'Product is already assigned to the user';
      return true;
    }

    public function getErrors() {
      return $this->_errors;
    }

    public function getProductsOfUser($userId) {
      $productsWithSymptoms = $this->_db->select('user_products', [
        'Columns' => ['product_id', 'symptoms'],
        'Conditions' => ['user_id' => ['=', $userId]]
      ]);

      $userProducts = [];

      if(!empty($productsWithSymptoms)) {
        $productEngine = new ProductEngine();
        foreach($productsWithSymptoms as $product) {
          $userProducts[] = $productEngine->getById($product['product_id']);
          end($userProducts)->symptoms = $product['symptoms'];
        }
      }
      return $userProducts;
    }
  }