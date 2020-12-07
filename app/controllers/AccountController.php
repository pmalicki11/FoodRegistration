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
      $this->_view->errors = [];

      if(isset($_POST) && !empty($_POST)) {
        $this->_account = Account::build()
          ->setUsername($_POST['username'])
          ->setPassword($_POST['password']);

        if($this->_account->login()) {
          $userAgent = UserSessions::userAgentNoVersion();
          $this->_userSessions = UserSessions::build()
            ->setAccountId($this->_account->getId())
            ->setUserAgent($userAgent);
          $this->_userSessions->remove();
            
          if(isset($_POST['remember']) && $_POST['remember'] == 'on') {
            $sessionCookie = md5(rand()) . md5(rand());
            $this->_userSessions->setSessionId($sessionCookie);
            $this->_userSessions->add();
            setcookie(COOKIENAME, $sessionCookie, time() + COOKIEDURABILITY, PROOT);
          }

          $_SESSION['user'] = $this->_account->toArray();
          header('Location: '. PROOT .'home/index');
          die();
        }
        $this->_view->errors = $this->_account->getErrors();
      }
      $this->_view->render('account/login');
    }

    public function logoutAction() {
      session_destroy();
      setcookie(COOKIENAME, "", time() - 3600, PROOT);
    
      $user = Account::currentLoggedIn();
      $userAgent = UserSessions::userAgentNoVersion();
      $this->_userSessions = UserSessions::build()
        ->setAccountId($user['id'])
        ->setUserAgent($userAgent);
      $this->_userSessions->remove();

      header('Location: '. PROOT .'home/index');
      die();
    }
  }