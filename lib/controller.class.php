<?php

class Controller {

    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_template;
    protected $_validate;
    protected $authenticated;
    protected $Mail;

    function __construct($model, $controller, $action) {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_model = $model;
        $this->$model = new $model;
        $this->_validate = new Validation();
        $this->_template = new Template($controller, $action);
        $this->authenticated = false;
        $this->Mail = new Mail();
        
        if (isset($_POST) && !empty($_POST)) {
            $this->set('_OLD_STATE', $this->getRequest(INPUT_POST));
        }
    }

    function set($name, $value) {
        $this->_template->set($name, $value);
    }

    function __destruct() {
        $this->_template->render();
    }

    function getRequest($requset) {
        return $this->cleanInputs(filter_input_array($requset));
    }

    private function cleanInputs($data, $html = 0) {
        if (is_array($data)) {
            $clean_data = array();
            foreach ($data as $k => $v) {
                $clean_data[$k] = $this->cleanInputs($v, $html);
            }
            return $clean_data;
        } else {
            if (get_magic_quotes_gpc()) {
                $data = stripslashes($data);
            }
            $data = trim($data);
            if (!$html) {
                $data = htmlspecialchars($data);
                $pat = array("\r\n", "\n\r", "\n", "\r");
                $data = str_replace($pat, '<br>', $data); // newlines to <br>
                $pat = array('/^\s+/', '/\s{2,}/', '/\s+\$/');
                $rep = array('', ' ', '');
                $data = preg_replace($pat, $rep, $data); // remove multiple whitespaces
                $data = trim($data);
            }
            return ($data); // escape stuff mysql_real_escape_string
        }
    }

}

?>
