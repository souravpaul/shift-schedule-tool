<?php

class AccountController extends Controller{
    
    
    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        

        if ($this->Account->check_user()) {
            $this->_template->set('loggedin',true);
            $this->authenticated=true;
        }
    }
            
    
    function login(){
        if(!isset($_GET['attempt']) || empty($_GET['attempt'])){
            return;
        }
        
        if (!isset($_POST) || empty($_POST)) {
            $this->_template->status('Invalid form submission.', 0, ERROR);
            return;
        }

        /************* Validation ***************/
        $post=  filter_input_array(INPUT_POST);
        if(isset($post['username']) && !empty($post['username'])){
            $user['username']=$post['username'];            
        }else{
            $this->_template->status('Invalid username or password.', 0, ERROR);
            return;
        }
        if(isset($post['password']) && !empty($post['password'])){
            $user['password']=md5($post['password']);        
        }else{
            $this->_template->status('Invalid username or password.', 0, ERROR);
            return;
        }
        if($this->Account->login($user)){
            redirect('account/home');
        }else{
            $this->_template->status('Invalid username or password.', 0, ERROR);            
        }
    }
    
    function logout(){
        $this->Account->logout();
        redirect('account/login');
    }
    
    function home(){
        if(!$this->authenticated){
            redirect('account/login');
        }
    }
    
    function isExixts($user_name){
        
    }
            
    function add($user){
        
    }
    
}
