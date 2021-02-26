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
      $this->_view->errors = [];

      if(isset($_POST) && !empty($_POST)) {


        $this->_account = Account::build()
          ->setUsername($_POST['username'])
          ->setPassword($_POST['password'])
          ->setRePassword($_POST['repassword'])
          ->setEmail($_POST['email']);
        
        if($this->_account->register()) {
          Router::redirect('home/index');
        } 

        $this->_view->errors = $this->_account->getErrors();
      }
      $this->_view->render('account/register');
    }


    public function loginAction() {
      if(!Request::isEmpty()) {
        $user = new User();
        $user->setFromRequest();
        $errors = $user->validate();

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
  }