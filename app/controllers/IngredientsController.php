<?php

  class IngredientsController {

    private $_view;

    public function __construct() {
      $this->_view = new View();
    }

    public function indexAction() {
      $this->_view->render('ingredients/index');
    }

    public function addAction() {
      if(!Request::isEmpty()) {
        var_dump(Request::get('name'));
        $ingredient = new Ingredient();
        $ingredient->setFromRequest();
        $errors = $ingredient->validate();
        if(empty($errors)) {
          $engine = new IngredientEngine();
          if($engine->add($ingredient)) {
            Router::redirect('ingredients/index');
          }
          $errors = $engine->getErrors();
        }

        $this->_view->errors = $errors;
      }
      $this->_view->render('ingredients/add');
    }

  }