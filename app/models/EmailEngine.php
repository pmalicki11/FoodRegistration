<?php

use PHPMailer\PHPMailer\PHPMailer;

class EmailEngine {
  
  private $_mail;

  public function __construct() {
    require_once(ROOT . DS . 'vendor' . DS . 'phpmailer' . DS . 'PHPMailer.php'); 
    require_once(ROOT . DS . 'vendor' . DS . 'phpmailer' . DS . 'SMTP.php'); 
    
    $this->_mail = new PHPMailer();
    $this->_mail->From = MAIN_EMAIL_ADDRESS;
    $this->_mail->FromName = MAIN_EMAIL_NAME;
    $this->_mail->Host = MAIN_EMAIL_HOST;
    $this->_mail->Mailer = 'smtp';
    $this->_mail->isSMTP();
    $this->_mail->SMTPAuth = true;
    $this->_mail->Username = MAIN_EMAIL_USERNAME;
    $this->_mail->Password = MAIN_EMAIL_PASSWORD;
    $this->_mail->Port = 587;
    $this->_mail->SMTPSecure = 'tls';
    $this->_mail->CharSet = "utf-8";
    $this->_mail->IsHTML(true);
  }
  

  public function sendRegistrationEmail($user) {
    $recipient = $user->email;
    $subject = 'Account registration';
    $message = '<h2>Hello ' . $user->username . '!</h2><hr>
      <h4>Thanks for registration in Food Registration App!</h4>
      <p>There is only one step before you will be able to use application. Please click link below to finalize your registration process.</p>
      <a href="' . DOMAIN . PROOT . 'account/activate?token=' . $user->active . '">' . DOMAIN . PROOT . 'account/activate?token=' . $user->active . '</a>';
    return $this->sendEmail($recipient, $subject, $message);
  }


  public function sendActivationEmail($user) {
    $recipient = $user->email;
    $subject = 'Account activation';
    $message = '<h2>Hello ' . $user->username . '!</h2><hr>
      <h4>Your account in Food Registration App has been activated successfully!</h4>
      <p>You can login <a href="' . DOMAIN . PROOT . 'account/login">here</a></p>';
    return $this->sendEmail($recipient, $subject, $message);
  }


  private function sendEmail($recipient, $subject, $message) {
    $this->_mail->Subject = $subject;
    $this->_mail->Body = $message;     
    $this->_mail->AddAddress ($recipient);
    return $this->_mail->Send();
  }
}