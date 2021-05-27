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
  

  public function sendEmail($recipient, $subject, $message) {
    $this->_mail->Subject = $subject;
    $this->_mail->Body = $message;     
    $this->_mail->AddAddress ($recipient);
    return $this->_mail->Send();
  }

  public function sendActivationEmail($user) {
    $recipient = $user->email;
    $subject = 'Account activation';
    $message = '<h1>Hello ' . $user->username . '</h1>';
    $message .= '<p>You have successfully registered your account in Food Regsitration App.';
    $message .= 'To be able to take ful advantage of the App you need to activate your account by clikcking link below.<br>';
    $message .= DOMAIN . PROOT . 'account/activate?token=' . $user->active . '</p>';
    return $this->sendEmail($recipient, $subject, $message);
  }
}