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

  public function setFromRequest($request) {
    $this->username = $request->username;
    $this->password = $request->password;
    $this->email = $request->email;
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

  public function validate() {
    $this->_validators[] = new LengthValidator('username', $this->username, 4, 50);
    $this->_validators[] = new LengthValidator('password', $this->password, 4, 50);
    $errors = [];
    foreach($this->_validators as $validator) {
      if($validator->run())
        $errors[] = $validator->run();
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