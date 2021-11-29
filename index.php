<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  define('DS', DIRECTORY_SEPARATOR);
  define('ROOT', dirname(__FILE__));
  require_once(ROOT . DS . 'app' . DS . 'config' . DS . 'config.php');
  require_once(ROOT . DS . 'app' . DS . 'models' . DS . 'User.php');

  session_start();

  function autoload($className) {
    if(file_exists(ROOT . DS . 'core' . DS . $className . '.php')) {
      require_once(ROOT . DS . 'core' . DS . $className . '.php');
    } elseif (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
      require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
    } elseif (file_exists(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php')) {
      require_once(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php');
    } elseif (file_exists(ROOT . DS . 'app' . DS . 'validators' . DS . $className . '.php')) {
      require_once(ROOT . DS . 'app' . DS . 'validators' . DS . $className . '.php');
    }
  }

    spl_autoload_register('autoload');

    if(!Session::currentUser()) {
      $authenticator = new Authenticator();
      $authenticator->loginFromCookie();
    }

    $url = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];
    
    Router::route($url);
