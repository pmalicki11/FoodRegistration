<?php
  $this->setSiteTitle('Ingredients -add');
  $this->start('body');
?>

<div class="row align-items-center justify-content-center mt-5">
  <div class="col-lg-6 bg-light p-4 m-5 border border-secondary rounded">
    <h2 class="text-center">Add ingredient</h2>

    <?php if(!empty($this->errors)) : ?>
      <div class="alert alert-danger">
        <?php foreach($this->errors as $key => $value): ?>
          <span class="d-block"><?= $value; ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="add" method="post">

      <div class="form-group">
        <label for="name">Name:</label>
        <input class="form-control<?= array_key_exists('name', $this->errors) ? ' is-invalid' : ''; ?>"
          type="search" id="name" name="name" value="<?=Request::get('name');?>"
        >
      </div>

      <div class="form-group text-center">
        <input class="btn btn-dark" type="submit" value="Submit">
      </div>  
    </form>
  </div>
</div>
<?php $this->end(); ?>


