<?php

  class Router {
    
    public static function route($url) {
      $controller = ((count($url)) ? $url[0] : 'Home');
      $controllerName = ucfirst($controller) . 'Controller';
      array_shift($url);

      $defaultAction = ($controller == 'Account') ? 'profile' : 'index';

      $action = (count($url)) ? ($url[0]) : $defaultAction;
      $actionName = $action . 'Action';
      array_shift($url);

      $target = $controller . '/' . $action;

      if(self::checkAccess(Session::currentUser(), $target)) {
        
        $params = []; 
        if(count($url) > 1) {
          $params = $url;
        } elseif(count($url) == 1) {
          $params = $url[0];
        }
        
        $obj = new $controllerName(); 
        call_user_func([$obj, $actionName], $params);
      } else {
        self::redirect('home/index');
      }
    }

    public static function redirect($location) {
      header('Location: '. PROOT . $location);
    }

    public static function checkAccess($user, $target) {
      $role = $user->role ?? 'guest';
      $aclFile = ROOT . DS . 'app' . DS . 'config' . DS . 'acl.json';
      
      if(file_exists($aclFile)) {
        $acl = json_decode(file_get_contents($aclFile), true);
        
        $target = explode('/', $target);
        $targetController = $target[0];
        array_shift($target);
        $targetAction = (count($target)) ? $target[0] : 'index';
        if(array_key_exists($targetController, $acl[$role])) {
          $allowedController = $acl[$role][$targetController];
          if(in_array('*', $allowedController) || in_array($targetAction, $allowedController)) {
            return true;
          }
        }
      }
      return false;
    }

    public static function referer() {
      $refererUrl = $_SERVER['HTTP_REFERER'];
      return substr($refererUrl, strpos($refererUrl, PROOT) + strlen(PROOT));
    }

    public static function refererArray() {
      $array = explode('/', self::referer());
      $controller = array_shift($array);
      $action = '';
      $params = [];

      if(count($array) > 1) {
        $action = array_shift($array);
        $params[] = $array;

      } elseif(count($array) == 1) {
        $array = explode('?', $array[0]);
        $action = array_shift($array);
        $array = explode('&', $array[0]);
        
        foreach($array as $param) {
          $param = explode('=', $param);
          $params[$param[0]] = $param[1]; 
        }
      }

      return [
        'controller' => $controller,
        'action' => $action,
        'params' => $params
      ];
    }

    public static function currentPage() {
      return $_SERVER['PATH_INFO'];
    }

    public static function currentModule() {
      return explode('/', trim($_SERVER['PATH_INFO'], '/'))[0];
    }
  }
