<?php
  $this->setSiteTitle('Register');
  $this->start('body');
?>

<div class="row align-items-center justify-content-center">
  <div class="col-lg-6 bg-light p-4 m-5 border border-secondary rounded">
    <h2 class="text-center">Register</h2>
      <h3 class="text-center text-danger">! Registration is temporarily disabled !</h3>

    <?php if(!empty($this->errors)) : ?>
      <div class="alert alert-danger">
        <?php foreach($this->errors as $key => $value): ?>
          <span class="d-block"><?= $value; ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="register" method="post" autocomplete="new-password">

      <div class="form-group">
        <label for="username">Username:</label>
        <input class="form-control<?= array_key_exists('username', $this->errors) ? ' is-invalid' : ''; ?>"
          type="search" id="username" name="username" autocomplete="new-password" value="<?=Request::get('username');?>"
        >
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input class="form-control<?= (array_key_exists('password', $this->errors) || array_key_exists('repassword', $this->errors)) ? ' is-invalid' : ''; ?>"
          type="password" id="password" name="password"
        /> 
      </div>
      
      <div class="form-group">
        <label for="repassword">Repeat password:</label>
        <input class="form-control<?= array_key_exists('repassword', $this->errors) ? ' is-invalid' : ''; ?>"
          type="password" id="repassword" name="repassword"
        >
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input class="form-control<?= array_key_exists('email', $this->errors) ? ' is-invalid' : ''; ?>"
          type="text" id="email" name="email" value="<?=Request::get('email');?>"
        >
      </div>
      
      <div class="form-group text-center">
        <input class="btn btn-dark btn-lg" type="submit" value="Submit">
      </div>    
    </form>
  </div>
</div>
<?php $this->end(); ?>


