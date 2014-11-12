<?php

class Controller {
     
    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_template;
    protected $_validate;
    protected $authenticated;
 
    function __construct($model, $controller, $action) {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_model = $model;
        $this->$model = new $model;
        $this->_validate=new Validation();
        $this->_template = new Template($controller,$action);
        $this->authenticated=false;
    }
 
    function set($name,$value) {
        $this->_template->set($name,$value);
    }
 
    function __destruct() {
            $this->_template->render();
    }
         
}

?>
