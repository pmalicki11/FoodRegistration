<?php

  class ProductsController {

    private $_view;

    public function __construct() {
      $this->_view = new View();
    }

    public function indexAction() {
      $engine = new ProductEngine();
      $this->_view->products = $engine->getAll();
      $this->_view->render('products/index');
    }

    public function addAction() {
      if(!Request::isEmpty()) {
        $product = new Product();
        $product->setFromRequest();
        $errors = $product->validate();
        $ingredients = [];
        
        if(empty($errors)) {
          if($ingredientNames = Request::get('multiselectOption')) {
            $ingredientEngine = new IngredientEngine();
            foreach($ingredientNames as $ingredientName) {
              $ingredient = $ingredientEngine->getByName($ingredientName);
              $ingredients = array_merge($ingredients, $ingredient);
            }
          }
          
          $engine = new ProductEngine();
          if($engine->add($product, $ingredients)) {
            Router::redirect('products/index');
          }
          $errors = $engine->getErrors();
        }

        $this->_view->errors = $errors;
      }
      $this->_view->render('products/add');
    }

  }