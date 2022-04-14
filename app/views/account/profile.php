<?php
  $this->setSiteTitle('My Account');
  $this->start('head');
?>

<link rel="stylesheet" type="text/css" href="<?=PROOT . DS . 'app' . DS . 'css' . DS . 'profilePicture.css';?>">

<?php
  $this->end();
  $this->start('body');
?>

<div class="px-2">
  <h3 class="my-4">My Account</h3>
  <div class="container-fluid">
    <div class="row align-items-center p-4">
      <div class="col-sm-5">
        <div class="row mb-3">
          <div class="col-md-4 p-2 font-weight-bold">Username</div>
          <div class="col-md-8 p-2"><?=Session::currentUser()->username;?></div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4 p-2 font-weight-bold">Email</div>
          <div class="col-md-8 p-2"><?=Session::currentUser()->email;?></div>
        </div>
      </div>
      <div id="profilepicture" class="col-sm-7 text-center">
        <button id="addprofilepicturebutton" class="btn btn-dark m-3" role="button">
          <i class="bi bi-camera"></i>
          <span>Add picture</span>
        </button>
      </div>
    </div>

    <div class="row p-4">
      <div class="col-lg-8 py-4">
        <h4>My products</h4>
        <table class="table table-responsive table-striped">
          <thead class="thead-dark">
          <tr>
            <th class="align-middle" scope="col">Actions</th>
            <th class="align-middle" scope="col">Name</th>
            <th class="align-middle" scope="col">Symptoms</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach($this->userProducts as $product): ?>
            <tr>
              <td class="col-md-1 text-center">
                <a href="<?=PROOT;?>products/unassign/<?=$product->getId();?>" class="text-danger px-2"><i class="h5 bi bi-x-square"></i></a>
              </td>
              <td class="col-md-4">
                <a href="<?=PROOT;?>products/show/<?=$product->getId();?>"><?=$product->name;?></a>
              </td>
              <td class="col"><?=AllergySymptoms::getDescription($product->symptoms);?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="col-lg-4 py-4">
      <h4>Recurring ingredients</h4>
        <table class="table table-responsive table-striped">
          <thead class="thead-dark">
          <tr>
            <th class="align-middle" scope="col">Frequency</th>
            <th class="align-middle" scope="col">Name</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach($this->userIngredientsStats as $ingredientStats): ?>
            <tr>
              <td class="col-md-1"><?=$ingredientStats['count'];?></td>
              <td class="col-md-3"><?=$ingredientStats['name'];?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php $this->end(); ?>
