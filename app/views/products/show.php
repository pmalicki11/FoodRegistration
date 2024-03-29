<?php
  $this->setSiteTitle('Products');
  $this->start('body');
?>
<div class="container-fluid p-4">
  <div class="row p-3">
    <h3><?= $this->product->name; ?></h3>
  </div>

    <?php if($err = Session::getField('prodDelErr')) : ?>
      <div class="alert alert-danger">
        <span class="d-block"><?= $err ?></span>
      </div>
    <?php endif; ?>

    <div class="row px-3">
    <?php if(Session::currentUser()->role == 'admin') : ?>
      <a href="<?= PROOT; ?>products/edit/<?= $this->product->getId(); ?>" class="btn btn-outline-dark m-1" role="button">
        <i class="bi bi-pencil-fill"></i>
        <span>Edit</span>
      </a>
      <a href="<?= PROOT; ?>products/delete/<?= $this->product->getId(); ?>" class="btn btn-outline-danger m-1" role="button">
        <i class="bi bi-x"></i>
        <span>Delete</span>
      </a>
    <?php elseif(Session::currentUser()->getId() == $this->product->addedBy) : ?>
      <a href="<?= PROOT; ?>products/edit/<?= $this->product->getId(); ?>" class="btn btn-outline-dark m-1" role="button">
        <i class="bi bi-pencil-fill"></i>
        <span>Edit</span>
      </a>
    <?php endif; ?>
      <a href="<?= PROOT; ?>products/assign/<?= $this->product->getId(); ?>" class="btn btn-outline-success m-1" role="button">
        <i class="bi bi-clipboard-plus"></i>
        <span>Assign</span>
      </a>
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

<?php
  Session::unsetField('prodDelErr');
  $this->end();
?>
