<?php
  $menuFile = ROOT . DS . 'app' . DS . 'config' . DS . 'menu.json';
  if(file_exists($menuFile)) {

    $menu = json_decode(file_get_contents($menuFile));
    $user = Session::currentUser();

    $menuHTML = '<ul class="navbar-nav mr-auto">';
    foreach($menu as $menuDesc => $link) {
      if(Router::checkAccess($user, $link) && substr($link, 0, 7) != 'account') {
        $menuHTML .= '<li class="nav-item"><a class="nav-link" href="' . PROOT . $link . '" ' . isActive($link, 'module') . '>' . $menuDesc . '</a></li>';
      }
    }
    $menuHTML .= '</ul>';
    $menuHTML .= '<ul class="navbar-nav">';
    foreach($menu as $menuDesc => $link) {
      if(Router::checkAccess($user, $link) && substr($link, 0, 7) == 'account') {
        $menuHTML .= '<li class="nav-item"><a class="nav-link" href="' . PROOT . $link . '" ' . isActive($link) . '>' . $menuDesc . '</a></li>';
      }
    }
    $menuHTML .= '</ul>';
  }

  function isActive($link, $type = 'page') {
    if($type == 'module') {
      $module = Router::currentModule();
      $linkModule = explode('/', $link)[0];
      return ($module == $linkModule) ? ' style="color:#cced00;"' : '';
    } else if($type = 'page') {
      $currentLink = ltrim(Router::currentPage(), '/');
      return ($currentLink == $link) ? ' style="color:#cced00;"' : '';
    }
  }
?>

<nav class="navbar navbar-expand-md sticky-top navbar-dark bg-dark">
  <a class="navbar-brand" style="color:#cced00;" href="<?= PROOT; ?>home"><?= SITENAME; ?></a>
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <?= $menuHTML; ?>
  </div>
</nav>
