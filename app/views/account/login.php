<?php
  $this->setSiteTitle('Login');
  $this->start('body');
?>

<h1>Login Page</h1>

<div class="row align-items-center justify-content-center">
  <div class="col-md-6 bg-light p-4">
    <h2 class="text-center">Login</h2>

    <?php if(!empty($this->errors)) : ?>
      <div class="alert alert-danger">
        <?php foreach($this->errors as $key => $value): ?>
          <span class="d-block"><?= $value; ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>    

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


