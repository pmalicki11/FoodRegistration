<?php

  class Account {

    private $_id;
    private $_username;
    private $_password;
    private $_repassword;
    private $_salt;
    private $_email;
    private $_role;
    private $_active;
    private $_db;
    private $_errors;

    public function __construct() {
      $this->_errors = [];
      $this->_db = DB::getInstance();
    }

    public function getFromRequest() {
      echo 'test';
    }

    public static function build() {
      $instance = new self();
      return $instance;
    }
    public function setId($id) {
      $this->_id = $id;
      return $this;
    }
    public function setUsername($username) {
      $this->_username = $username;
      return $this;
    }
    public function setPassword($password) {
      $this->_password = $password;
      return $this;
    }
    public function setRePassword($repassword) {
      $this->_repassword = $repassword;
      return $this;
    }
    public function setEmail($email) {
      $this->_email = $email;
      return $this;
    }
    public function setRole($role) {
      $this->_role = $role;
      return $this;
    }
    public function setActive($active) {
      $this->_active = $active;
      return $this;
    }


    public function register() {

      if(empty($this->_username) || strlen($this->_username) < 5) {
        $this->_errors[] = ['username' => 'Username must be at least 5 characters long.'];
      }
      if(empty($this->_password) || strlen($this->_password) < 8) {
        $this->_errors[] = ['password' => 'Password must be at least 8 characters long.'];
      }
      if($this->_password != $this->_repassword) {
        $this->_errors[] = ['repassword' => 'Passwords must match.'];
      }
      if(!filter_var($this->_email, FILTER_VALIDATE_EMAIL)) {
        $this->_errors[] = ['email' => 'Wrong email.'];
      }

      if(empty($this->_errors)) {
        $this->_salt = bin2hex(random_bytes(16));
        $this->_password .= $this->_salt;
        $this->_password = hash("sha256", $this->_password);

        $params = [
          'username' => $this->_username,
          'password' => $this->_password,
          'salt' => $this->_salt,
          'email' => $this->_email,
          'role' => 'user',
          'active' => 1
        ];
        $this->save($params);
        return true;
      }
      return false;
    }

    public function save($params) {
      $this->_db->insert('accounts', $params);
    }


    public function login() {
      if(!empty($this->_username) && !empty($this->_password)) {

        $givenPassword = $this->_password;
        $conditions = [];
        $conditions['username'] = ['=', $this->_username];

        if($this->load($conditions)) {
          $givenPassword .= $this->_salt;
          $givenPassword = hash("sha256", $givenPassword);
          if($givenPassword == $this->_password) {
            if($this->_active) {
              return true;
            } else {
              $this->_errors[] = ['username' => 'Account for that username is not active.'];
              return false;
            }
          } else {
            $this->_errors[] = ['username' => 'Wrong credentials. Check your username and pasword'];
            return false;
          }
        } else {
          $this->_errors[] = ['username' => 'Wrong credentials. Check your username and pasword'];
          return false;
        }

        if(!$this->_active) {
          $this->_errors[] = ['username' => 'Account for that username is not active.'];
          return false;
        }
        
        return true;
      }

      if(empty($this->_username)) { $this->_errors[] = ['username' => 'Username can not be empty.']; }
      if(empty($this->_password)) { $this->_errors[] = ['password' => 'Password can not be empty.']; }

      return false;
    }


    public function loginFromCookie($cookie) {
      $userSession = UserSessions::build()->setSessionId($cookie);
      if($userSession->loadBySessionId()) {
        $conditions = [];
        $conditions['id'] = ['=', $userSession->getAccountId()];
        if($this->load($conditions) && $this->_active) { return true; }
      }
      return false;
    }


    public function load($conditions) {     
      $result = $this->_db->select('accounts', [
        'Columns' => ['*'],
        'Conditions' => $conditions
      ]);

      if(count($result) == 1) {
        $result = $result[0];
        $this->_id = $result['id'];
        $this->_username = $result['username'];
        $this->_password = $result['password'];
        $this->_salt = $result['salt'];
        $this->_email = $result['email'];
        $this->_role = $result['role'];
        $this->_active = $result['active'];
        return true;
      }
      return false;
    }

    public function isActive() {
      return $this->_active;
    }

    public function getId() {
      return $this->_id;
    }

    public function toArray() {
      return [
        'id' => $this->_id,
        'username' => $this->_username,
        'email' => $this->_email,
        'role' => $this->_role,
        'active' => $this->_active
      ];
    }

    public function getErrors() {
      return $this->_errors;
    }


    public static function currentLoggedIn() {
      return (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
    }

    
    public static function hasAccess($role, $target) {

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