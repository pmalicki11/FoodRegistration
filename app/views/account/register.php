<?php
  $this->setSiteTitle('Register');
  $this->start('body');
?>

<h1>Register Page</h1>
<?=($this->errors)?var_dump($this->errors):''; ?>

<form action="register" method="post">

  <label for="username">Username:</label>
  <input type="text" id="username" name="username" value="<?=Request::get('username');?>">

  <label for="password">Password:</label>
  <input type="text" id="password" name="password">

  <label for="repassword">Repeat password:</label>
  <input type="text" id="repassword" name="repassword">

  <label for="email">Email:</label>
  <input type="text" id="email" name="email" value="<?=Request::get('email');?>">

  <input type="submit" value="Submit">

</form>

<?php $this->end(); ?>


