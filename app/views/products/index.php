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
        <th scope="col">Name</th>
        <th scope="col">Producer</th>
        <th scope="col">Portion</th>
        <th scope="col">Energy</th>
        <th scope="col">Fat</th>
        <th scope="col">Carbohydrates</th>
        <th scope="col">Protein</th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    
    <tbody>
      <?php foreach($this->products as $product): ?>
      <tr>
          <td class="col-md-4">
            <a href="show/<?= $product->getId(); ?>"><?= $product->name; ?></a>
          </td>
          <td class="col-md-4"><?= $product->producer; ?></td> 
          <td class="col-md-1"><?= $product->portion; ?></td>
          <td class="col-md-1"><?= $product->energy; ?></td>
          <td class="col-md-1"><?= $product->fat; ?></td>
          <td class="col-md-1"><?= $product->carbohydrates; ?></td>
          <td class="col-md-1"><?= $product->protein; ?></td>
          <td class="col-md-1 text-center">
            <a href="edit/<?= $product->getId(); ?>" class="text-body"><i class="bi bi-pencil-square"></i></a>
          </td>
          <td class="col-md-1 text-center">
            <a href="delete/<?= $product->getId(); ?>" class="text-danger"><i class="bi bi-x-square"></i></a>
          </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php $this->end(); ?>