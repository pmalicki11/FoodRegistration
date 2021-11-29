<?php
  $this->setSiteTitle('Products');
  $this->start('body');
?>

<div class="px-2">
  <h3 class="my-4">Products</h3>

  <a href="<?= PROOT; ?>products/add" class="btn btn-outline-dark my-2" role="button">
    <i class="bi bi-plus"></i>
    <span>Add</span>
  </a>
  
  <table class="table table-responsive table-striped">
    
    <thead class="thead-dark">
      <tr>
        <th class="align-middle" scope="col">Name</th>
        <th class="align-middle" scope="col">Producer</th>
        <th class="align-middle text-center" scope="col">Portion <small>[g]</small></th>
        <th class="align-middle text-center" scope="col">Energy <small>[kcal]</small></th>
        <th class="align-middle text-center" scope="col">Fat <small>[g/100g]</small></th>
        <th class="align-middle text-center" scope="col">Carbs <small>[g/100g]</small></th>
        <th class="align-middle text-center" scope="col">Protein <small>[g/100g]</small></th>
        <th class="align-middle" scope="col"></th>
        <?php if(Session::currentUser()->role == 'admin') : ?>
          <th class="align-middle" scope="col"></th>
          <th class="align-middle" scope="col"></th>
        <?php endif; ?>
      </tr>
    </thead>
    
    <tbody>
      <?php foreach($this->products as $product): ?>
        <tr>
          <td class="col-md-4">
            <a href="show/<?= $product->getId(); ?>"><?= $product->name; ?></a>
          </td>
          <td class="col-md-2"><?= $product->producer; ?></td> 
          <td class="text-center"><?= $product->portion; ?></td>
          <td class="text-center"><?= $product->energy; ?></td>
          <td class="text-center"><?= $product->fat; ?></td>
          <td class="text-center"><?= $product->carbohydrates; ?></td>
          <td class="text-center"><?= $product->protein; ?></td>
          <td class="col-md-1 text-center">
              <a href="#/<?= $product->getId(); ?>" class="text-success"><i class="bi bi-clipboard-plus"></i></a>
          </td>
          <?php if(Session::currentUser()->role == 'admin') : ?>
            <td class="col-md-1 text-center">
              <a href="edit/<?= $product->getId(); ?>" class="text-body"><i class="bi bi-pencil-square"></i></a>
            </td>
            <td class="col-md-1 text-center">
              <a href="delete/<?= $product->getId(); ?>" class="text-danger"><i class="bi bi-x-square"></i></a>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php $this->end(); ?>
