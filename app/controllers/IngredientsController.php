<?php

  class IngredientsController {

    private $_view;

    public function __construct() {
      $this->_view = new View();
    }

    public function indexAction() {
      $engine = new IngredientEngine();
      $this->_view->ingredients = $engine->getAll();
      $this->_view->render('ingredients/index');
    }

    public function addAction() {
      if(!Request::isEmpty()) {
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

    public function deleteAction($id) {
      $engine = new IngredientEngine();
      //it should check if the ingredient isn't used in any product
      if(true) {
        $engine->delete($id);
      }
      Router::redirect('ingredients/index');
    }

  }