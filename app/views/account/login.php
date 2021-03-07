<?php
  $this->setSiteTitle('Login');
  $this->start('body');
?>

<h1>Login Page</h1>
<?=($this->errors) ? var_dump($this->errors) : ''; ?>

<div class="row align-items-center justify-content-center">
  <div class="col-md-6 bg-light p-4">

    <form action="login" method="post">
      <div class="form-group">
        <label for="username">Username:</label>
        <input class="form-control" type="text" id="username" name="username">
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input class="form-control" type="password" id="password" name="password">
      </div>

      <div class="form-group form-check">
        <input class="form-check-input" type="checkbox" id="remember" name="remember">
        <label for="remember">Remember me</label>
      </div>

      <input class="btn btn-primary" type="submit" value="Submit">    
    </form>
  </div>
</div>

<?php $this->end(); ?>


