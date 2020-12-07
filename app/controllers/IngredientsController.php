<?php

  class IngredientsController {

    private $_view;

    public function __construct() {
      $this->_view = new View();
    }

    public function indexAction() {
      $this->_view->render('ingredients/index');
    }

  }