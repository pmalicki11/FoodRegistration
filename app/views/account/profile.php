<?php
  $this->setSiteTitle('My Account');
  $this->start('head');
?>

<link rel="stylesheet" type="text/css" href="<?= PROOT.DS.'app'.DS.'css'.DS.'profilePicture.css'; ?>">

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
  </div>
</div>

<?php $this->end(); ?>
