<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
if (isset($_GET['url']) && !empty($_GET['url']))
    $url = $_GET['url'];
else
    $url = '';
#echo ROOT;
require_once (ROOT . DS . 'lib' . DS . 'bootstrap.php');
?>
