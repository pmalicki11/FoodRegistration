<?php

  class IngredientsController extends Controller {

    public function __construct() {
      parent::__construct();
    }

    public function indexAction() {
      $page = (isset($_REQUEST["page"]) && $_REQUEST["page"] > 0) ? $_REQUEST["page"] : 1;
      $offset = 0;
      if($page != 1) {
        $offset = $page * INGREDIENTS_PER_INDEX_PAGE - INGREDIENTS_PER_INDEX_PAGE + 1;
      }

      $engine = new IngredientEngine();
      $this->view->ingredients = $engine->getAll(INGREDIENTS_PER_INDEX_PAGE, $offset);
      $ingredientsCount = count($engine->getAll());
      $this->view->totalPages = ceil(($ingredientsCount - 1) / INGREDIENTS_PER_INDEX_PAGE);
      $this->view->currentPage = $page;
      $this->view->render('ingredients/index');
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
        $this->view->errors = $errors;
      }
      $this->view->render('ingredients/add');
    }

    public function editAction($id) {
      if(Request::isEmpty()) {
        $engine = new IngredientEngine();
        $ingredient = $engine->getById($id);
        Request::set([
          'id' => $ingredient->getId(),
          'name' => $ingredient->name
        ]);
        $this->view->mode = 'edit';
        $this->view->render('ingredients/add');

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
        $this->view->errors = $errors;
        Request::set(['id' => $ingredient->getId()]);
        $this->view->mode = 'edit';
        $this->view->render('ingredients/add');
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
      
      $page = '?page=' . Router::refererArray()['params']['page'] ?? 1;  
      Router::redirect('ingredients/index' . $page);
    }

  }
