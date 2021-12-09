<?php
  $this->setSiteTitle('Products');
  $this->start('body');
?>

<div class="row align-items-center justify-content-center mt-3">
  <div class="col-lg-8 bg-light p-4 m-5 border border-secondary rounded">

    <h3 class="text-center">Add product to my list</h3>

    <div class="container-fluid p-4">
      <div class="row p-3">
        <h4><?= $this->product->name; ?></h4>
      </div>
      <div class="row">
        <div class="col-lg-5 p-2">
          <h5 class="p-2">Nutrition info</h5>
          <table class="table">
            <tbody>
            <?php foreach($this->product->nutritionInfo() as $key => $value): ?>
              <tr>
                <td class="font-weight-bold"><?= ucfirst($key); ?></td>
                <td><?= $value; ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="col-lg-7 p-2">
          <h5 class="p-2">Ingredients</h5>
          <ul class="list-unstyled">
            <?php foreach($this->ingredients as $ingredient): ?>
              <li><i class="bi bi-arrow-right-short"></i><?= $ingredient->name; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>

    <?php if(!empty($this->errors)) : ?>
      <div class="alert alert-danger">
        <?php foreach($this->errors as $key => $value): ?>
          <span class="d-block"><?= $value; ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="post">
      <input type="hidden" id="id" name="id" value="<?=Request::get('id');?>">
      <div class="form-group">
        <label for="symptoptoms">Allergy symptoms:</label>
        <div class="input-group mb-3">
          <select name="symptoptoms" class="custom-select" id="symptoptoms">
            <option hidden>Select...</option>
            <?php foreach(AllergySymptoms::getAll() as $value => $description): ?>
              <option value="<?= $value; ?>"><?= $description; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group text-center">
        <input class="btn btn-dark" type="submit" value="Submit">
      </div>
    </form>
  </div>
</div>

<?php $this->end(); ?>
