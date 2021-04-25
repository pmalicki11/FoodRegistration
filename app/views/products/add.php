<?php
  $this->setSiteTitle('Products');
  $this->start('head');
?>

  <link rel="stylesheet" type="text/css" href="<?= PROOT.DS.'vendor'.DS.'multiselect-autocomplete'.DS.'css'.DS.'multiselect-autocomplete.css'; ?>">

<?php
  $this->end();
  $this->start('body');

  if(isset($this->mode)) {
    $this->mode = PROOT . 'products/edit/' . Request::get('id');
  } else {
    $this->mode = PROOT . 'products/add';
  }

?>

<div class="row align-items-center justify-content-center mt-5">
  <div class="col-lg-6 bg-light p-4 m-5 border border-secondary rounded">
    <h3 class="text-center">Add product</h3>

    <?php if(!empty($this->errors)) : ?>
      <div class="alert alert-danger">
        <?php foreach($this->errors as $key => $value): ?>
          <span class="d-block"><?= $value; ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= $this->mode; ?>" method="post">

      <input type="hidden" id="id" name="id" value="<?=Request::get('id');?>">

      <div class="form-group">
        <label for="name">Name:</label>
        <input class="form-control<?= array_key_exists('name', $this->errors) ? ' is-invalid' : ''; ?>"
          type="search" id="name" name="name" value="<?=Request::get('name');?>" autofocus
        >
      </div>

      <div class="form-group">
        <label for="producer">Producer:</label>
        <input class="form-control<?= array_key_exists('producer', $this->errors) ? ' is-invalid' : ''; ?>"
          type="text" id="producer" name="producer" value="<?=Request::get('producer');?>"
        >
      </div>

      <div class="form-group">
        <label for="portion">Portion:</label>
        <input class="form-control<?= array_key_exists('portion', $this->errors) ? ' is-invalid' : ''; ?>"
          type="text" id="portion" name="portion" value="<?=Request::get('portion');?>" placeholder="g"
        >
      </div>

      <div class="form-group">
        <label for="energy">Energy:</label>
        <input class="form-control<?= array_key_exists('energy', $this->errors) ? ' is-invalid' : ''; ?>"
          type="text" id="energy" name="energy" value="<?=Request::get('energy');?>" placeholder="kcal"
        >
      </div>

      <div class="form-group">
        <label for="fat">Fat:</label>
        <input class="form-control<?= array_key_exists('fat', $this->errors) ? ' is-invalid' : ''; ?>"
          type="text" id="fat" name="fat" value="<?=Request::get('fat');?>" placeholder="g/100g"
        >
      </div>

      <div class="form-group">
        <label for="carbohydrates">Carbohydrates:</label>
        <input class="form-control<?= array_key_exists('carbohydrates', $this->errors) ? ' is-invalid' : ''; ?>"
          type="text" id="carbohydrates" name="carbohydrates" value="<?=Request::get('carbohydrates');?>" placeholder="g/100g"
        >
      </div>

      <div class="form-group">
        <label for="protein">Protein:</label>
        <input class="form-control<?= array_key_exists('protein', $this->errors) ? ' is-invalid' : ''; ?>"
          type="text" id="protein" name="protein" value="<?=Request::get('protein');?>" placeholder="g/100g"
        >
      </div>

      <?php if($options = Request::get('multiselectOption')) : ?>
        <div id="initOptions" class="d-none multiselect-autocomplete-init-options">
          <?= json_encode(array_values($options)); ?>
        </div>
      <?php endif; ?>

      <div class="form-group">
        <label for="ingeredients">Ingredients:</label>
        <div id='ingeredients' class="multiselect-autocomplete"></div>
      </div>
      
      <div class="form-group text-center">
        <input class="btn btn-dark" type="submit" value="Submit">
      </div> 

    </form>
  </div>
</div>
<script src="<?= PROOT.DS.'vendor'.DS.'multiselect-autocomplete'.DS.'js'.DS.'multiselect-autocomplete.js'; ?>"></script>
<?php $this->end(); ?>
