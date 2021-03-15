<?php

class User {

  private $_id;
  public $username;
  public $password;
  public $salt;
  public $email;
  private $role;
  public $active;
  private $_validators = [];

  public function __construct() {
  }

  public function getId() {
    return $this->_id;
  }

  public function setFromRequest() {
    $this->username = Request::get('username');
    $this->password = Request::get('password');
    $this->email = Request::get('email');
  }

  public function setFromDatabase($data) {
    $this->_id = $data['id'];
    $this->username = $data['username'];
    $this->password = $data['password'];
    $this->salt = $data['salt'];
    $this->email = $data['email'];
    $this->role = $data['role'];
    $this->active = $data['active'];
  }

  public function validateOnLogin() {
    $this->_validators[] = new LengthValidator('username', $this->username, 1, 50);
    $this->_validators[] = new LengthValidator('password', $this->password, 1, 50);
    $errors = [];
    foreach($this->_validators as $validator) {
      if($validator->run()) {
        $errors = array_merge($errors, $validator->run()); 
      }
    }
    return $errors;
  }

  public function validateOnRegister() {
    $this->_validators[] = new LengthValidator('username', $this->username, 4, 50);
    $this->_validators[] = new LengthValidator('password', $this->password, 4, 50);
    $this->_validators[] = new PasswordMatchValidator('repassword', $this->password, Request::get('repassword'));
    $this->_validators[] = new EmailValidator('email', $this->email);

    $errors = [];
    foreach($this->_validators as $validator) {
      if($validator->run()) {
        $errors = array_merge($errors, $validator->run());   
      }
      //$errors[] = $validator->run();
    }
    return $errors;
  }

  public function toArray() {
    return [
      'id' => $this->_id,
      'username' => $this->username,
      'email' => $this->email,
      'role' => $this->role,
      'active' => $this->active
    ];
  }
}