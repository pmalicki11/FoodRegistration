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

    public function editAction($id) {
      if(Request::isEmpty()) {
        $engine = new IngredientEngine();
        $ingredient = $engine->getById($id);
        Request::set([
          'id' => $ingredient->getId(),
          'name' => $ingredient->name
        ]);
        $this->_view->mode = 'edit';
        $this->_view->render('ingredients/add');

      } else {
        $ingredient = new Ingredient();
        $ingredient->setFromRequest();
        $errors = $ingredient->validate();
        if(empty($errors)) {
          $engine = new IngredientEngine();
          if($engine->edit($ingredient)) {
            Router::redirect('ingredients/index');
          }
          $errors = $engine->getErrors();
        }
        $this->_view->errors = $errors;
        Request::set(['id' => $ingredient->getId()]);
        $this->_view->mode = 'edit';
        $this->_view->render('ingredients/add');
      }
    }

    public function deleteAction($id) {
      $engine = new IngredientEngine();
      //it should check if the ingredient isn't used in any product
      if(true) {
        $engine->delete($id);
      }
      Router::redirect('ingredients/index');
    }

    public function ajaxAction() {
      $namePart = $_REQUEST["namepart"];
      $engine = new IngredientEngine();
      $ingredients = $engine->getByName($namePart.'%');

      if($ingredients) {
        $jsonOut = '[';
        foreach($ingredients as $ingredient) {
          //$jsonOut .= '{'; 
          //$jsonOut .= '"id" : "'.$ingredient->getId().'",'; 
          //$jsonOut .= '"name" : "'.$ingredient->name.'"';
          //$jsonOut .= '},';
          $jsonOut .= '"'.$ingredient->name.'",';
        }
        $jsonOut = rtrim($jsonOut, ',');
        $jsonOut .= ']';
        header("Access-Control-Allow-Origin: http://*, https://*");
        header("Content-Type: application/json");
        echo $jsonOut;
        die();
      } else {
        echo '';
      }
   }
  }