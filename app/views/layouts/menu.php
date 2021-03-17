<?php
  $menuFile = ROOT . DS . 'app' . DS . 'config' . DS . 'menu.json';
  if(file_exists($menuFile)) {

    $menu = json_decode(file_get_contents($menuFile));
    $userRole = 'guest';
    $currentUser = Session::currentUser();

    if($currentUser) {
      $userRole = $currentUser['role'];
    }

    $menuHTML = '<ul class="navbar-nav mr-auto">';
    foreach($menu as $menuDesc => $link) {
      if(Router::checkAccess($userRole, $link) && substr($link, 0, 7) != 'account') {
        $menuHTML .= '<li class="nav-item"><a class="nav-link" href="' . PROOT . $link . '">' . $menuDesc . '</a></li>';
      }
    }
    $menuHTML .= '</ul>';
    $menuHTML .= '<ul class="navbar-nav">';
    foreach($menu as $menuDesc => $link) {
      if(Router::checkAccess($userRole, $link) && substr($link, 0, 7) == 'account') {
        $menuHTML .= '<li class="nav-item"><a class="nav-link" href="' . PROOT . $link . '">' . $menuDesc . '</a></li>';
      }
    }
    $menuHTML .= '</ul>';
  }
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?= PROOT; ?>home"><?= SITENAME; ?></a>
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <?= $menuHTML; ?>
  </div>
</nav>