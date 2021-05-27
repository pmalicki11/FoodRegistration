<?php

  class AccountController {

    private $_view;
    private $_account;
    private $_userSessions;

    public function __construct() {
      $this->_view = new View();
    }


    public function profileAction() {
      $this->_view->render('account/profile');
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
        $this->_view->errors = $errors;
      }
      $this->_view->render('account/register');
    }


    public function loginAction() {
      if(!Request::isEmpty()) {
        $user = new User();
        $user->setFromRequest();
        $errors = $user->validateOnLogin();

        if(empty($errors)) {
          $authenticator = new Authenticator();
          if($authenticator->loginUser($user)) {            
            $authenticator->removeUserSession();
            if(Request::get('remember') == 'on') {
              $userSession = new UserSession($user);
              $authenticator->addUserSession($userSession);
              Cookie::setRememberCookie($userSession->getSessionId());
            }
            Session::setUserSession($user);
            Router::redirect('home/index');
          }
          $errors = $authenticator->getErrors();
        }
        $this->_view->errors = $errors;
      }
      $this->_view->render('account/login');   
    }

    
    public function logoutAction() {
      $authenticator = new Authenticator();
      $authenticator->removeUserSession();
      session_destroy();
      Cookie::deleteRememberCookie();
      Router::redirect('home/index');
    }


    public function activateAction() {
      echo "Account activated! (fake)";
    }
  }