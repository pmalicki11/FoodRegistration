<?php

  session_start();

  define('DS', DIRECTORY_SEPARATOR);
  define('ROOT', str_replace(['/', '\\'], DS, $_SERVER['DOCUMENT_ROOT']) . DS . 'foodregistration');
  require_once(ROOT . DS . 'app' . DS . 'config' . DS . 'config.php');

  function autoload($className) {
    if(file_exists(ROOT . DS . 'API' . DS . $className . '.php')) {
      require_once(ROOT . DS . 'API' . DS . $className . '.php');
    } elseif(file_exists(ROOT . DS . 'core' . DS . $className . '.php')) {
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

  $requestUrl = isset($_SERVER['REQUEST_URI']) ? explode('/', trim($_SERVER['REQUEST_URI'], '/')) : [];
  $requestObject = $requestUrl[2];
  $requestMethod = $requestUrl[3];
  if(strpos($requestUrl[3], '?')) {
    $requestMethod = strstr($requestUrl[3], '?', true);
  }

  $requestParams = $_REQUEST;
  $request = new APIRequest($requestObject, $requestMethod);

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json");
  echo $request->call($requestParams);
  die();
