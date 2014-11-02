<?php

class TeamsController extends Controller {

    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        $account=new Account;
        if ($account->check_user()) {
            $this->_template->set('loggedin', true);
            $this->authenticated = true;
        }
    }

    //put your code here
    function add() {
        
        if(!$this->authenticated){
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }
        
        if($_SESSION['ADMIN_TYPE']!='PROJECT_ADMIN' && $_SESSION['ADMIN_TYPE']!='APP_ADMIN'){
            $this->_template->status('You do not have permission to Create/Remove any Teams.', 0, ERROR);
            redirect('teams/viewall');  
            return;          
        }
        
        if (!isset($_GET['attempt']) || empty($_GET['attempt'])) {
            return;
        }

        if (!isset($_POST) || empty($_POST)) {
            $this->_template->status('Invalid form submission.', 0, ERROR);
            return;
        }
        $team = filter_input_array(INPUT_POST);
        $error=array();
        if (!$this->_validate->isNotBlank($team['team_name'])) {
            array_push($error, array(
                'target_block' => 1,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!$this->_validate->isAlpha($team['team_name'], ' ')) {
             array_push($error, array(
                'target_block' => 1,
                'code' => ERROR,
                'message' => 'Only letters are allowed.'
            ));
        }
        $account=new Account;
        if (!$this->_validate->isNotBlank($team['admin_username'])) {
            array_push($error, array(
                'target_block' => 2,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } /*else if (!$this->_validate->isAlphaNumeric($team['admin_username'],'_@')) {
             array_push($error, array(
                'target_block' => 2,
                'code' => ERROR,
                'message' => 'Only letters and numbers are allowed.'
            ));
        }*/else if(!$account->check_username($team['admin_username'])){
             array_push($error, array(
                'target_block' => 2,
                'code' => ERROR,
                'message' => 'Username already exists.Please Try another one.'
            ));
        }

        if (!$this->_validate->isNotBlank($team['password'])) {
            array_push($error, array(
                'target_block' => 3,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if ($team['password']!=$team['conf_password']) {
             array_push($error, array(
                'target_block' => 4,
                'code' => ERROR,
                'message' => 'Password does not match.'
            ));
        }
        $team['password']=md5($team['password']);
        
        if (sizeof($error) > 0) {
            $this->_template->status('Please fill the form properly', 0, ERROR, $error);
            return;
        }
        /* Save */
        if ($this->Team->add($team)) {
            $this->_template->status('Team has been created successfully.', 0, SUCCESS);
            redirect('teams/viewall');
        } else {
            $this->_template->status('Server problem. Please try again soon.', 0, SERVER_PROBLEM);
        }
    }

    function viewall() {
        $result = $this->Team->viewall();
        if ($result !== false || empty($result)) {
            $this->_template->set('team_list', $result);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
    }

    function fetch($team_id) {
        
        if(!$this->authenticated){
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }
        
        $result = $this->Team->view($team_id);
        if ($result !== false) {
            $this->_template->set('team', $result);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
    }

    function update() {
        
        if(!$this->authenticated){
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }
        
        if($_SESSION['ADMIN_TYPE']!='PROJECT_ADMIN' && $_SESSION['ADMIN_TYPE']!='APP_ADMIN'){
            $this->_template->status('You do not have permission to Create/Remove any Teams.', 0, ERROR);
            redirect('teams/viewall');  
            return;
        }
        
        if (!isset($_POST) || empty($_POST)) {
            $this->_template->status('Invalid form submission.', 0, ERROR);
            return;
        }
        $team = filter_input_array(INPUT_POST);

        if (!$this->_validate->isNotBlank($team['team_name'])) {
            $this->_template->status('Can\'t be blank.', 1, ERROR);
        } else if (!$this->_validate->isAlpha($team['team_name'])) {
            $this->_template->status('Only letters are allowed.', 1, ERROR);
        }

        /* Save */
        if ($this->Team->update($team)) {
            $this->_template->status('Team has been created successfully.', 0, SUCCESS);
        } else {
            $this->_template->status('Server problem. Please try again soon.', 0, SERVER_PROBLEM);
        }
    }

    function remove($team_id) {
        
        if(!$this->authenticated){
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }
        
        if($_SESSION['ADMIN_TYPE']!='PROJECT_ADMIN' && $_SESSION['ADMIN_TYPE']!='APP_ADMIN'){
            $this->_template->status('You do not have permission to Create/Remove any Teams.', 0, ERROR);
            redirect('teams/viewall');  
            return;
        }
        
        $result = $this->Team->remove($team_id);
        if ($result) {
            $this->_template->status('Team has been deleted successfully.', 0, SUCCESS);
            redirect('teams/viewall');
        } else {
            $this->_template->status('Failed to delete Team..Please try again soon.', 0, ERROR);
        }
    }

}
