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

    public function showAction($id) {
      $productEngine = new ProductEngine();
      $ingredientEngine = new IngredientEngine();
      $this->_view->product = $productEngine->getById($id);
      $this->_view->ingredients = $ingredientEngine->getAllForProduct($id);
      $this->_view->render('products/show');
    }

    public function deleteAction($id) {
      $productEngine = new ProductEngine();
      $productEngine->delete($id);
      Router::redirect('products/index');
    }
  }