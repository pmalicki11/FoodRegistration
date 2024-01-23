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

    public function unassign($userId, $productId) {
      $params = [
        'Conditions' => [
          'user_id' => $userId,
          'product_id' => $productId
        ]
      ];

      $this->_db->delete('user_products', $params);  
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

    public function isProductAssignedToAnyUser($productId) {
      $result = $this->_db->select('user_products', [
        'Columns' => ['*'],
        'Conditions' => [
          'product_id' => ['=', $productId],
          'user_id' => ['!=', '']
        ]
      ]);

      return (!empty($result));
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

    public function getUserIngredientsStats($userId, $moreThanOne) {
      $userProducts = $this->_db->select('user_products', [
        'Columns' => ['product_id'],
        'Conditions' => ['user_id' => ['=', $userId]]
      ]);

      $productIds = [];
      foreach($userProducts as $userProduct) {
        $productIds[] = $userProduct['product_id'];
      }

      $userIngredients = empty($productIds) ? [] : $this->_db->select('product_ingredients', [
        'Columns' => ['ingredient_id'],
        'Conditions' => ['product_id' => ['IN', $productIds]]]
      );

      $ingredientsStats = [];
      $ingredientEngine = new IngredientEngine();
      foreach($userIngredients as $userIngredient) {
        $id = $userIngredient['ingredient_id'];
        if(!isset($ingredientsStats[$id])) {
          $ingredientsStats[$id] = [
            'name' => $ingredientEngine->getById($id)->name,
            'count' => 1
          ];
        } else {
          $ingredientsStats[$id]['count']++;
        }
      }

      if ($moreThanOne) {
        $ingredientsStats = array_filter($ingredientsStats, function($item) {
          return $item['count'] > 1; 
        });
      }

      array_multisort(
        array_column($ingredientsStats, 'count'), SORT_DESC,
        array_column($ingredientsStats, 'name'), SORT_ASC,
        $ingredientsStats
      );

      return $ingredientsStats;
    }
  }
