<?php

/** Check if environment is development and display errors * */
function setReporting() {
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', 'Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
    }
}

date_default_timezone_set("Asia/Calcutta");
if (!isset($_SESSION)) {
    session_start();
}

/** Check for Magic Quotes and remove them * */
function stripSlashesDeep($value) {
    $value = is_array($value) ? array_map('cleanInputs', $value) : stripslashes($value);
    return $value;
}

function removeMagicQuotes() {
    //if (get_magic_quotes_gpc()) 
    {
       /* $_GET = cleanInputs($_GET);
        $_POST = cleanInputs($_POST);
        $_COOKIE = cleanInputs($_COOKIE);*/
    }
}




/** Get Required Files * */
gzipOutput() || ob_start("ob_gzhandler");

/** GZip Output * */
function gzipOutput() {
    $ua = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');

    if (0 !== strpos($ua, 'Mozilla/4.0 (compatible; MSIE ') || false !== strpos($ua, 'Opera')) {
        return false;
    }

    $version = (float) substr($ua, 30);
    return (
            $version < 6 || ($version == 6 && false === strpos($ua, 'SV1'))
            );
}

/* * **** Redirect Action ****** */
$_REDIRECT['LINK'] = "";
$_REDIRECT['HOLD_MESSSAGE'] = "";

function redirect($url, $hold_message = "") {
    global $_REDIRECT;
    $_REDIRECT['LINK'] = $url;
    $_REDIRECT['HOLD_MESSSAGE'] = $hold_message;
    die();
}

/** Check register globals and remove them * */
function unregisterGlobals() {
    /*  if (ini_get('register_globals')) {
      $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
      foreach ($array as $value) {
      foreach ($GLOBALS[$value] as $key => $var) {
      if ($var === $GLOBALS[$key]) {
      unset($GLOBALS[$key]);
      }
      }
      }
      } */
}

/** Main Call Function * */
function callHook() {
    global $url;

    $urlArray = array();
    $urlArray = explode("/", $url);

    $controller = strtolower($urlArray[0]);
    array_shift($urlArray);
    $action = strtolower($urlArray[0]);
    array_shift($urlArray);
    $queryString = $urlArray;

    $controllerName = $controller;
    $controller = ucwords($controller);
    $model = rtrim($controller, 's');
    $controller = strtolower($controller) . 'Controller';
    $dispatch = new $controller($model, $controllerName, $action);

    if ((int) method_exists($controller, $action)) {
        call_user_func_array(array($dispatch, $action), $queryString);
    } else {
        /* Error Generation Code Here */
    }
}

/** Autoload any classes that are required * */
function __autoload($className) {
    if (file_exists(ROOT . DS . 'lib' . DS . strtolower($className) . '.class.php')) {
        require_once(ROOT . DS . 'lib' . DS . strtolower($className) . '.class.php');
    } else if (file_exists(ROOT . DS . 'apps' . DS . 'controllers' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'apps' . DS . 'controllers' . DS . $className . '.php');
    } else if (file_exists(ROOT . DS . 'apps' . DS . 'models' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'apps' . DS . 'models' . DS . strtolower($className) . '.php');
    } else {
        /* Error Generation Code Here */
    }
}

setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();
?>
