<?php

class Template {

    protected $variables = array();
    protected $_controller;
    protected $_action;

    function __construct($controller, $action) {
        $this->_controller = $controller;
        $this->_action = $action;
    }

    /** Set Variables * */
    function set($name, $value) {
        $this->variables[$name] = $value;
    }

    function status($message, $target, $code = ERROR, $additional = array()) {
        $status['MESSAGE'] = $message;
        $status['TARGET'] = $target;
        $status['CODE'] = $code;
        $status['DATA'] = $additional;


        switch ($code) {
            case SERVER_PROBLEM:
            case ERROR: $status['CLASS'] = 'error';
                break;

            case SUCCESS: $status['CLASS'] = 'success';
                break;

            case WARNING: $status['CLASS'] = 'warning';
                break;
        }

        $this->set('_STATUS', $status);
    }

    /** Display Template * */
    function render() {
        
        global $_REDIRECT;
        if(strlen($_REDIRECT['LINK'])>5){
           $this->send_redirect($_REDIRECT['LINK'],$_REDIRECT['HOLD_MESSSAGE']);
        }
        
        if (isset($_SESSION['_STATUS']) && !empty($_SESSION['_STATUS'])) {
            $this->set('_STATUS', $_SESSION['_STATUS']);
            unset($_SESSION['_STATUS']);
        }
        
        $html = new HTML();
        extract($this->variables);

        ob_start();

        include (ROOT . DS . 'apps' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');

        if (file_exists(ROOT . DS . 'apps' . DS . 'views' . DS . $this->_controller . DS . 'footer.php')) {
            include (ROOT . DS . 'apps' . DS . 'views' . DS . $this->_controller . DS . 'footer.php');
        } else {
            include (ROOT . DS . 'apps' . DS . 'views' . DS . 'footer.php');
        }

        $body = ob_get_contents();
        ob_end_clean();
        
        ob_start();
        if (file_exists(ROOT . DS . 'apps' . DS . 'views' . DS . $this->_controller . DS . 'header.php')) {
            include (ROOT . DS . 'apps' . DS . 'views' . DS . $this->_controller . DS . 'header.php');
        } else {
            include (ROOT . DS . 'apps' . DS . 'views' . DS . 'header.php');
        }

        $head = ob_get_contents();
        ob_end_clean();
        
        echo '
            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
            <html>
                <head>
                    <title>' . $html->title . '</title>
        <link rel="stylesheet" type="text/css" media="screen"
              href="'.WEBROOT.'public/css/baseStyle.css" />
        <link rel="stylesheet" type="text/css" media="screen"
              href="'.WEBROOT.'public/css/style.css" />
                    <script type="text/javascript" src="'.WEBROOT.'public/js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="'.WEBROOT.'public/js/base.js"></script>
                    ' . $html->headConf . '
                </head>
                <body>
                    ' . $head.$body . $html->endScript . '
                </body>
            </html>
';
    }
    
     private function send_redirect($url,$hold_message=""){
        if(isset($this->variables['_STATUS']) && !empty($this->variables['_STATUS'])){
            $_SESSION['_STATUS']=$this->variables['_STATUS'];
        }
        $url=WEBROOT.$url;
        if(!headers_sent()) {
            //If headers not sent yet... then do php redirect
            header('Location: '.$url);
            exit;
        } else {
            //If headers are sent... do javascript redirect... if javascript disabled, do html redirect.
            echo '<h2>'.$hold_message.'. Please wait....</h2>';
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.$url.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
            echo '</noscript>';
            exit;
        }
    }

}

?>
