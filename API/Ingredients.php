<?php

  class Ingredients {

    public function getList($params) {

      $response = [
        'status' => ResponseStatus::ok,
        'message' => ''
      ];

      if(empty($params['namepart'])) {
        $response['status'] = ResponseStatus::badRequest;
        return $response;
      }

      $engine = new IngredientEngine();
      $ingredients = $engine->getByName($params['namepart'] . '%');
      $names = [];
      if($ingredients) {
        foreach($ingredients as $ingredient) {
          $names[] = $ingredient->name;
        }
      }
    
      if(empty($names)) {
        $response['status'] = ResponseStatus::notFound;
        return $response;
      }

      $response['message'] = json_encode(array_values($names));
      return $response;
    }

    public function add() {
      $response = [
        'status' => ResponseStatus::created,
        'message' => ''
      ];
      
      if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['status'] = ResponseStatus::methodNotAllowed;
        return $response;

      } elseif(empty($_POST['name'])) {
        $response['status'] = ResponseStatus::badRequest;
        return $response;
      }
      
      $ingredient = new Ingredient();
      $ingredient->name = $_POST['name'];
      $errors = $ingredient->validate();
      
      if(empty($errors)) {
        $engine = new IngredientEngine();
        $engine->add($ingredient);
        $errors = $engine->getErrors();
      }

      if(!empty($errors)) {
        return [
          'status' => ResponseStatus::conflict,
          'message' => json_encode(array_values($errors))
        ];
      }

      return $response;
    }
  }
