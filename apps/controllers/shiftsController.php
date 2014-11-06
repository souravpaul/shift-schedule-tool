<?php

class ShiftsController extends Controller{

    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        $account=new Account;
        if ($account->check_user()) {
            $this->_template->set('loggedin', true);
            $this->authenticated = true;
        }
    }
    
    function add(){
        
        if(!$this->authenticated){
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }
        
        if($_SESSION['ADMIN_TYPE']!='TEAM_ADMIN'){
            $this->_template->status('You do not have permission to Create/Remove any Team Shift Structure.', 0, ERROR);
            redirect('shifts/view/'.$_SESSION['TEAM_ID']);  
            return;
        }
        
        if (!isset($_GET['attempt']) || empty($_GET['attempt'])) {
            return;
        }
        
        $shift = $this->getRequest(INPUT_POST);
        $error = array();
        if (!$this->_validate->isNotBlank($shift["start_time"])) {
            array_push($error, array(
                'target_block' => 1,
                'code' => ERROR,
                'message' => 'Please select starting time'
            ));
        }
        
        if (!$this->_validate->isNotBlank($shift["end_time"])) {
            array_push($error, array(
                'target_block' => 2,
                'code' => ERROR,
                'message' => 'Please select ending time'
            ));
        }
        
        if (!$this->_validate->isNotBlank($shift["shift_type"])) {
            array_push($error, array(
                'target_block' => 3,
                'code' => ERROR,
                'message' => 'Please select ending time'
            ));
        }else if ($shift["shift_type"]!='general' && $shift["shift_type"]!='oncall') {
            array_push($error, array(
                'target_block' => 3,
                'code' => ERROR,
                'message' => 'Invalid selection.'
            ));
        }
        
        if (!$this->_validate->isNotBlank($shift["shift_days"])) {
            array_push($error, array(
                'target_block' => 4,
                'code' => ERROR,
                'message' => 'Please select ending time'
            ));
        }else if ($shift["shift_days"]!='weekday' && $shift["shift_days"]!='weekend' && $shift["shift_days"]!='both') {
            array_push($error, array(
                'target_block' => 4,
                'code' => ERROR,
                'message' => 'Invalid selection.'
            ));
        }
        
        if (sizeof($error) > 0) {
            $this->_template->status('Please fill the form properly', 0, ERROR, $error);
            return;
        }
        $shift['team_id']=$_SESSION['TEAM_ID'];
        print_r($shift);
        if ($this->Shift->add($shift)) {
            $this->_template->status('New shift structure has been added successfully.', 0, SUCCESS);
            redirect('shifts/view/'.$shift['team_id']);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
        
    }
    
    function view($team_id){
        $result = $this->Shift->view($team_id);
        if ($result !== false) {
            $this->_template->set('shift_list', $result);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
        
    }
    
    function viewall(){
    }
    
    function update($structure){
        
    }
    
    function remove($shift_id){
        
        if(!$this->authenticated){
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }
        
        if($_SESSION['ADMIN_TYPE']!='TEAM_ADMIN'){
            $this->_template->status('You do not have permission to Create/Remove any Teams.', 0, ERROR);
            redirect('shifts/view/'.$_SESSION['TEAM_ID']);  
            return;
        }
        
        $result = $this->Shift->remove($shift_id,$_SESSION['TEAM_ID']);
        if ($result) {
            $this->_template->status('Shift has been deleted successfully.', 0, SUCCESS);
            redirect('shifts/view/'.$_SESSION['TEAM_ID']);
        } else {
            $this->_template->status('Failed to delete Shift..Please try again soon.', 0, ERROR);
        }
        
    }
}
