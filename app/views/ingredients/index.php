<?php
  $this->setSiteTitle('Ingredients');
  $this->start('body');
?>

<div class="px-2">
  <h3 class="my-4">Ingredients</h3>

  <?php if($err = Session::getField('ingDelErr')) : ?>
    <div class="alert alert-danger">
      <span class="d-block"><?= $err ?></span>
    </div>
  <?php endif; ?>

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

  <?php if($this->totalPages > 1) : ?>
    <ul class="pagination justify-content-center">
    
    <li class="page-item<?= ($this->currentPage == 1) ? ' disabled' : ''; ?>">
      <a class="page-link" href="<?=PROOT;?>ingredients/index?page=<?= $this->currentPage - 1; ?>"><- Previous</a>
    </li>

      <?php if($this->totalPages > 5 && $this->currentPage > 2) : ?>
        <li class="page-item disabled"><a class="page-link" href="3">...</a></li>
      <?php endif; ?>

      
      <?php
        $startPage = 1;
        $endPage = $this->totalPages;
        if($this->totalPages > 5) {
          if($this->currentPage > 2 && ($this->totalPages - $this->currentPage) > 2) {
            $startPage = $this->currentPage - 1;
            $endPage = $this->currentPage + 1;
          } elseif($this->currentPage > 2) {
            $startPage = $this->totalPages - 3;
          } elseif(($this->totalPages - $this->currentPage) > 2) {
            $endPage = 4;
          }
        }

        for($i = $startPage; $i <= $endPage; $i++) {
      ?>
        <li class="page-item">
          <a class="page-link<?= ($i == $this->currentPage) ? ' bg-dark text-light' : '';?>"
            href="<?=PROOT;?>ingredients/index?page=<?=$i;?>"><?=$i;?>
          </a>
        </li>
      <?php } ?>
    
      <?php if($this->totalPages > 5 && $this->totalPages - $this->currentPage > 2) : ?>
        <li class="page-item disabled"><a class="page-link" href="3">...</a></li>
      <?php endif; ?>

    <li class="page-item<?= ($this->currentPage == $this->totalPages) ? ' disabled' : ''; ?>">
      <a class="page-link" href="<?=PROOT;?>ingredients/index?page=<?= $this->currentPage + 1; ?>">Next -></a>
    </li>

    </ul>
  <?php endif; ?>

</div>

<?php
  Session::unsetField('ingDelErr');
  $this->end();
?>