<?php

  class Router {
    
    public static function route($url) {
      
      $controller = ((count($url)) ? ucfirst($url[0]) : 'Home').'Controller';
      array_shift($url);

      $defaultAction = ($controller == 'AccountController') ? 'profileAction' : 'indexAction';

      $action = (count($url)) ? ($url[0] . 'Action') : $defaultAction;
      array_shift($url);
      
      $params = (count($url)) ? $url : [];

      $obj = new $controller();

      call_user_func([$obj, $action], $params);
    }

    public static function redirect($location) {
      header('Location: '. PROOT . $location);
      die();
    }
  }