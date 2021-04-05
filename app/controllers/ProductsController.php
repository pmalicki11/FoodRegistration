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
        if(empty($errors)) {
          $engine = new ProductEngine();
          if($engine->add($product)) {
            Router::redirect('products/index');
          }
          $errors = $engine->getErrors();
        }

        $this->_view->errors = $errors;
      }
      $this->_view->render('products/add');
    }

  }