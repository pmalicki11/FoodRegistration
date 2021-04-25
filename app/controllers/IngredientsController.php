<?php

  class IngredientsController {

    private $_view;

    public function __construct() {
      $this->_view = new View();
    }

    public function indexAction() {
      $page = (isset($_REQUEST["page"]) && $_REQUEST["page"] > 0) ? $_REQUEST["page"] : 1;
      $rowCount = 12;
      $offset = 0;
      if($page != 1) {
        $offset = $page * $rowCount - $rowCount + 1;
      }

      $engine = new IngredientEngine();
      $this->_view->ingredients = $engine->getAll($rowCount, $offset);
      $ingredientsCount = count($engine->getAll());
      $this->_view->totalPages = ceil(($ingredientsCount - 1) / $rowCount);
      $this->_view->currentPage = $page;
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
      $ingredientEngine = new IngredientEngine();
      $productEngine = new ProductEngine();
      if($productEngine->getByIngredientId($id) == null) {
        $ingredientEngine->delete($id);
      } else {
        Session::setField(['ingDelErr' => 'Can not delete! Ingredient is referenced by at least one product.']);
      }
      Router::redirect('ingredients/index');
    }

    public function ajaxAction() {
      header("Access-Control-Allow-Origin: *");
      header("Content-Type: application/json");

      $namePart = $_REQUEST["namepart"];
      $engine = new IngredientEngine();
      $ingredients = $engine->getByName($namePart.'%');
      $names = [];
      if($ingredients) {
        foreach($ingredients as $ingredient) {
          $names[] = $ingredient->name;
        }
      }
      echo json_encode(array_values($names));
   }
  }