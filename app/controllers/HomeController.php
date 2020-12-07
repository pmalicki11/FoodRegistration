<?php

  class HomeController {

    private $_view;

    public function __construct() {
      $this->_view = new View();
    }

    public function indexAction() {
      $this->_view->render('home/index');
    }

  }