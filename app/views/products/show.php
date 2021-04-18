<?php
  $this->setSiteTitle('Products');
  $this->start('body');
  //var_dump($this->product);
  //var_dump($this->ingredients);
?>
<div class="container-fluid p-4">
  <div class="row p-3">
    <h3><?= $this->product->name; ?></h3>
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


  

<?php $this->end(); ?>