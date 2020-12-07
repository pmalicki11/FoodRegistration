<?php

  class ProductsController {

    private $_view;

    public function __construct() {
      $this->_view = new View();
    }

    public function indexAction() {
      $this->_view->render('products/index');
    }

  }