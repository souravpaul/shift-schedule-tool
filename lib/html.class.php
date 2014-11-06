<?php
class HTML{

    public $endScript="";
    public $headConf="";
    public $title="";
    public $headLink="";
    
    function includeJS($fileName,$baseScript=true){
        $data = '<script src="'.WEBROOT.'js/'.$fileName.'.js" type="text/javascript"></script>';
	if ($baseScript) {
            $this->headConf.=$data;
        } else {
            $this->endScript.=$data;
        }
    }
    
    
    function includeCss($fileName) {
	$data = '<link rel="stylesheet" href="'.WEBROOT.'css/'.$fileName.'.css" type="text/css" media="all"></link>';
	$this->headConf.= $data;
    }
    
    
    function includeImg($fileName) {
	$data = '<img src="'.WEBROOT.'img/'.$fileName.'jpg" media="all"></link>';
	echo $data;
    }
    
    function setTitle($title){
        $this->title=$title;
    }    
    
    function setHeadLink($name,$link){
        $this->headLink.="<li><a href='".WEBROOT."$link'>$name</a></li>";
    }
    
}


