<?php

  class AccountController extends Controller {

    public function __construct() {
      parent::__construct();
    }

    public function profileAction() {
      $userProductsEngine = new UserProductsEngine();
      $this->view->userProducts = $userProductsEngine->getProductsOfUser(Session::currentUser()->getId());
      $this->view->render('account/profile');
    }

    public function registerAction() {
      if(!Request::isEmpty()) {
        $user = new User();
        $user->setFromRequest();
        $errors = $user->validateOnRegister();
        if(empty($errors)) {
          $registrator = new Registrator();
          if($registrator->registerUser($user)) {
            Router::redirect('account/login');
          }
          $errors = $registrator->getErrors();
        }
        $this->view->errors = $errors;
      }
      $this->view->render('account/register');
    }

    public function loginAction() {
      if(!Request::isEmpty()) {
        $user = new User();
        $user->setFromRequest();
        $errors = $user->validateOnLogin();

        if(empty($errors)) {
          $authenticator = new Authenticator();
          if($authenticator->loginUser($user)) {
            $authenticator->removeUserSession($user);
            if(Request::get('remember') == 'on') {
              $userSession = new UserSession($user);
              $authenticator->addUserSession($userSession);
              Cookie::setRememberCookie($userSession->getSessionId());
            }
            Session::setUserSession($user);
            $jwt = new JWT();
            Cookie::setJWTCookie($jwt->getTokenForUser($user));
            Router::redirect('home/index');
          }
          $errors = $authenticator->getErrors();
        }
        $this->view->errors = $errors;
      }
      $this->view->render('account/login');   
    }

    public function logoutAction() {
      $authenticator = new Authenticator();
      $authenticator->removeUserSession(Session::currentUser());
      session_destroy();
      Cookie::deleteRememberCookie();
      Cookie::deleteJWTCookie();
      Router::redirect('home/index');
    }

    public function activateAction() {
      $token = $_REQUEST["token"];
      $activator = new Activator($token);
      $activator->activateAccount();
      $this->view->errors = $activator->getErrors();
      $this->view->render('account/login');
    }
  }
