<?php

  class Ingredients {

    public function add($params) {
      $namePart = $params['namepart'];
      $engine = new IngredientEngine();
      $ingredients = $engine->getByName($namePart.'%');
      $names = [];
      if($ingredients) {
        foreach($ingredients as $ingredient) {
          $names[] = $ingredient->name;
        }
      }
      return !empty($names) ? json_encode(array_values($names)) : 'null';
    }
  }
