<?php
  $this->setSiteTitle('Login');
  $this->start('body');
?>

<div class="row align-items-center justify-content-center">
  <div class="col-lg-6 bg-light p-4 m-5 border border-secondary rounded">
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
        <input class="form-control<?= array_key_exists('username', $this->errors) ? ' is-invalid' : ''; ?>"
          type="text" id="username" name="username" value="<?=Request::get('username');?>"
        />
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input class="form-control<?= (array_key_exists('password', $this->errors) || array_key_exists('repassword', $this->errors)) ? ' is-invalid' : ''; ?>"
          type="password" id="password" name="password"
        />
      </div>

      <div class="form-group form-check">
        <input class="form-check-input" type="checkbox" id="remember" name="remember">
        <label for="remember">Remember me</label>
      </div>

      <div class="form-group text-center">
        <input class="btn btn-dark btn-lg" type="submit" value="Submit">
      </div>
      
      <div class="text-center">
        <span>Need an account? <a href="<?=PROOT; ?>account/register">Register!</a></span>
      </div>

    </form>
  </div>
</div>

<?php $this->end(); ?>


