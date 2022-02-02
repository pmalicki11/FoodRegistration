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

    public function editAction($id) {
      if(Request::isEmpty()) {
        $productEngine = new ProductEngine();
        $ingredientEngine = new IngredientEngine();
        $product = $productEngine->getById($id);
        $ingredients = $ingredientEngine->getAllForProduct($id);
        $ingredientNames = [];
        
        foreach($ingredients as $ingredient) {
          $ingredientNames[] = $ingredient->name;
        }

        Request::set([
          'id' => $product->getId(),
          'name' => $product->name,
          'producer' => $product->producer,
          'portion' => $product->portion,
          'energy' => $product->energy,
          'fat' => $product->fat,
          'carbohydrates' => $product->carbohydrates,
          'protein' => $product->protein,
          'multiselectOption' => $ingredientNames
        ]);
        $this->_view->mode = 'edit';
        $this->_view->render('products/add');

      } else {
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
          if($engine->edit($product, $ingredients)) {
            Router::redirect('products/index');
          }
          $errors = $engine->getErrors();
        }
        $this->_view->errors = $errors;
        Request::set(['id' => $product->getId()]);
        $this->_view->mode = 'edit';
        $this->_view->render('products/add');
      }
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
      $userProductsEngine = new UserProductsEngine();
      if(!$userProductsEngine->isProductAssignedToAnyUser($id)) {
        $productEngine->delete($id);
      } else {
        Session::setField(['prodDelErr' => 'Can not delete! Product is assigned to at least one user.']);
      }
      
      $referer = Router::referer();
      Router::redirect($referer);
    }

    public function assignAction($id) {
      if(!Request::isEmpty()) {
        $symptoms = Request::get('symptoms');
        if(!empty($symptoms) && $symptoms != 0) {
          $userProductsEngine = new UserProductsEngine();
          if($userProductsEngine->assign(Session::currentUser()->getId(), $id, $symptoms)) {
            Router::redirect('account/profile');
          } else {
            $this->_view->errors = $userProductsEngine->getErrors();
          }
        } else {
          $this->_view->errors = ['symptoms' => 'Symptoms are required'];
        }
      }

      $productEngine = new ProductEngine();
      $this->_view->product = $productEngine->getById($id);
      $ingredientEngine = new IngredientEngine();
      $this->_view->ingredients = $ingredientEngine->getAllForProduct($id);
      $this->_view->render('products/assign');
    }

    public function unassignAction($id) {
      $productEngine = new ProductEngine();
      $productEngine->unassign($id);
      Router::redirect('account/profile');
    }
  }
