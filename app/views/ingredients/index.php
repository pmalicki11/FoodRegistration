<?php
  $this->setSiteTitle('Ingredients');
  $this->start('body');
?>

<div class="px-5">
  <h3 class="my-4">Ingredients</h3>

  <a href="<?= PROOT; ?>ingredients/add" class="btn btn-outline-dark my-2" role="button">
    <i class="bi bi-plus"></i>
    <span>Add</span>
  </a>
  
  <table class="table table-striped">
    
    <thead class="thead-dark">
      <tr>
        <th scope="col">Name</th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    
    <tbody>  
      <?php foreach($this->ingredients as $ingredient): ?>
      <tr>
          <td class="col-md-10"><?= $ingredient->name; ?></td>
          <td class="col-md-1 text-center">
            <a href="edit/<?= $ingredient->getId(); ?>" class="text-body"><i class="bi bi-pencil-square"></i></a>
          </td>
          <td class="col-md-1 text-center">
            <a href="delete/<?= $ingredient->getId(); ?>" class="text-danger"><i class="bi bi-x-square"></i></a>
          </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php $this->end(); ?>