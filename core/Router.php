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

    public static function checkAccess($role, $target) {
      $aclFile = ROOT . DS . 'app' . DS . 'config' . DS . 'acl.json';
      
      if(file_exists($aclFile)) {
        $acl = json_decode(file_get_contents($aclFile));
        
        $target = explode('/', $target);
        $targetController = $target[0];
        array_shift($target);
        $targetAction = (count($target)) ? $target[0] : 'index';
    
        if(array_key_exists($targetController, $acl->$role)) {
          $allowedController = $acl->$role->$targetController;
          if(in_array('*', $allowedController) || in_array($targetAction, $allowedController)) {
            return true;
          }
        }
      }
      return false;
    }
  }