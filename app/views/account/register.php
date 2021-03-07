<?php
  $this->setSiteTitle('Register');
  $this->start('body');
?>

<h1>Register Page</h1>
<?=($this->errors)?var_dump($this->errors):''; ?>

<div class="row align-items-center justify-content-center">
  <div class="col-md-6 bg-light p-4">

    <form action="register" method="post" autocomplete="new-password">

      <div class="form-group">
        <label for="username">Username:</label>
        <input class="form-control" type="text" id="username" name="username" autofocus value="<?=Request::get('username');?>">
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input class="form-control" type="password" id="password" name="password"> 
      </div>
      
      <div class="form-group">
        <label for="repassword">Repeat password:</label>
        <input class="form-control" type="password" id="repassword" name="repassword">
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input class="form-control" type="text" id="email" name="email" value="<?=Request::get('email');?>">
      </div>

      <input class="btn btn-primary" type="submit" value="Submit">    
    </form>
  </div>
</div>
<?php $this->end(); ?>


