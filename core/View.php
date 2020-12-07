<?php

  class View {

    private $_layout = 'default';
    private $_viewsDirectory = ROOT . DS . 'app' . DS . 'views' . DS;
    private $_head;
    private $_body;
    private $_outputBuffer;
    private $_siteTitle;
    public $errors = [];


    public function __construct() {
    }


    public function render($view) {
      $view = str_replace('/', DS, $view);
      if(file_exists($this->_viewsDirectory . $view . '.php')) {
        include $this->_viewsDirectory . $view . '.php';
        include $this->_viewsDirectory . 'layouts' . DS . $this->_layout . '.php';
      } else {
        die('The view "' . $view . '" does not exist.');
      }
    }


    public function setLayout($layout) {
      $this->_layout = $layout;
    }


    public function start($type) {
      $this->_outputBuffer = $type;
      ob_start();
    }


    public function end() {
      if($this->_outputBuffer == 'head') {
        $this->_head = ob_get_clean();
      } elseif($this->_outputBuffer == 'body') {
        $this->_body = ob_get_clean();
      } else {
        die('You must first run the start method.');
      }
    }


    public function content($type) {
      if($type == 'head') {
        return $this->_head;
      } elseif($type == 'body') {
        return $this->_body;
      }
      return false;
    }


    public function setSiteTitle($title) {
      $this->_siteTitle = $title;
    }


    public function getSiteTitle() {
      return $this->_siteTitle;
    }
  }
