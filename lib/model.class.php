<?php

class Model extends SQLQuery {

    protected $_model;

    function __construct() {

        if (!$this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME))
            die('DB load failed');
        $this->_model = get_class($this);
        $this->_table = strtolower($this->_model) . "s";
    }

    function __destruct() {
        $this->disconnect();
    }

}

?>
