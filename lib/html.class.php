<?php
class HTML{

    public $endScript="";
    public $headConf="";
    public $title="";
    
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
    
    public function link($name,$url,$keyframe=true){
        if ($keyframe) {
            $data = '<a href="' . WEB_BASE . '/keyframe/' . $url . '" >' . $name . '</a>';
        } else {
            $data = '<a href="' . WEB_BASE . '/' . $url . '" >' . $name . '</a>';
        }
        echo $data;        
    }
    
}


