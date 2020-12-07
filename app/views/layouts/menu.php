<?php
  $menuFile = ROOT . DS . 'app' . DS . 'config' . DS . 'menu.json';
  if(file_exists($menuFile)) {

    $menu = json_decode(file_get_contents($menuFile));
    $userRole = 'guest';
    $currentUser = Account::currentLoggedIn();

    if($currentUser) {
      $userRole = $currentUser['role'];
    }

    $menuHTML = '<ul>';
    foreach($menu as $menuDesc => $link) {
      if(Account::hasAccess($userRole, $link)) {
        $menuHTML .= '<li><a href="' . PROOT . $link . '">' . $menuDesc;
        if($link == 'account/profile') { $menuHTML .= ' (' . $currentUser['username'] . ')'; }
        $menuHTML .= '</a></li>';
      }
    }
    $menuHTML .= '</ul>';
    echo $menuHTML;
  }
