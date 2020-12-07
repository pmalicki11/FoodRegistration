<?php
  $this->setSiteTitle('Login');
  $this->start('body');
?>

<h1>Login Page</h1>
<?=($this->errors)?var_dump($this->errors):''; ?>

<form action="login" method="post">

  <label for="username">Username:</label>
  <input type="text" id="username" name="username">

  <label for="password">Password:</label>
  <input type="text" id="password" name="password">

  <label for="remember">Remember me</label>
  <input type="checkbox" id="remember" name="remember">

  <input type="submit" value="Submit">
  
</form>

<?php $this->end(); ?>


