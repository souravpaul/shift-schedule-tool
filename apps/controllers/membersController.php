<?php

class MembersController extends Controller{
//	public  $authenticated=false;
    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        $account=new Account;
        if ($account->check_user()) {
            $this->_template->set('loggedin', true);
            $this->authenticated = true;
        }
    }

    function add() {
		echo $this->authenticated;
        if(!$this->authenticated){
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
			return;
        }
        
        if($_SESSION['ADMIN_TYPE']!='TEAM_ADMIN'){
            $this->_template->status('You do not have permission to Create/Remove any Member.', 0, ERROR);
            redirect('members/viewall');  
            return;
        }
        
        if (!isset($_GET['attempt']) || empty($_GET['attempt'])) {
            return;
        }

        if (!isset($_POST) || empty($_POST)) {
            $this->_template->status('Invalid form submission.', 0, ERROR);
            return;
        }

        /*         * *********** Validation ************** */
        $member = filter_input_array(INPUT_POST);
        $error = array();
        if (!$this->_validate->isNotBlank($member["fname"])) {
            array_push($error, array(
                'target_block' => 1,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!$this->_validate->isAlpha($member["fname"])) {
            array_push($error, array(
                'target_block' => 1,
                'code' => ERROR,
                'message' => 'Only letters are allowed.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["mname"])) {
            //Bypass
        }if (!$this->_validate->isAlpha($member["mname"], " ")) {
            array_push($error, array(
                'target_block' => 2,
                'code' => ERROR,
                'message' => 'Only letters are allowed.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["lname"])) {
            array_push($error, array(
                'target_block' => 3,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!$this->_validate->isAlpha($member["lname"])) {
            array_push($error, array(
                'target_block' => 3,
                'code' => ERROR,
                'message' => 'Only letters are allowed.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["pj_id"])) {
           /* array_push($error, array(
                'target_block' => 4,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));*/
        } else if (!$this->_validate->isAlphaNumeric($member["pj_id"])) {
            array_push($error, array(
                'target_block' => 4,
                'code' => ERROR,
                'message' => 'Only alphanumerics are allowed.'
            ));
        }  else if(!$this->Member->isExists($member["pj_id"],'PJ')){
            array_push($error, array(
                'target_block' => 4,
                'code' => ERROR,
                'message' => 'User already exists with this Id.'
            ));            
        }

        if (!$this->_validate->isNotBlank($member["pj_email"])) {
           /* array_push($error, array(
                'target_block' => 5,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));*/
        } else if (!filter_var($member["pj_email"], FILTER_VALIDATE_EMAIL)) {
            array_push($error, array(
                'target_block' => 5,
                'code' => ERROR,
                'message' => 'Invalid email format.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["pj_role"])) {
            //Bypass
        } else if (!$this->_validate->isAlphaNumeric($member["pj_role"])) {
            array_push($error, array(
                'target_block' => 6,
                'code' => ERROR,
                'message' => 'Only alphanumerics are allowed.'
            ));
        }


        if (!$this->_validate->isNotBlank($member["cmp_id"])) {
            array_push($error, array(
                'target_block' => 7,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!$this->_validate->isAlphaNumeric($member["cmp_id"])) {
            array_push($error, array(
                'target_block' => 7,
                'code' => ERROR,
                'message' => 'Only alphanumerics are allowed.'
            ));
        }  else if(!$this->Member->isExists($member["cmp_id"],'CMP')){
            array_push($error, array(
                'target_block' => 7,
                'code' => ERROR,
                'message' => 'User already exists with this Id.'
            ));            
        }

        if (!$this->_validate->isNotBlank($member["cmp_email"])) {
            array_push($error, array(
                'target_block' => 8,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!filter_var($member["cmp_email"], FILTER_VALIDATE_EMAIL)) {
            array_push($error, array(
                'target_block' => 8,
                'code' => ERROR,
                'message' => 'Invalid email format.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["cmp_role"])) {
            //Bypass
        } else if (!$this->_validate->isAlphaNumeric($member["cmp_role"])) {
            array_push($error, array(
                'target_block' => 9,
                'code' => ERROR,
                'message' => 'Only alphanumerics are allowed.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["contact_1"])) {
            array_push($error, array(
                'target_block' => 10,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!is_numeric($member["contact_1"])) {
            array_push($error, array(
                'target_block' => 10,
                'code' => ERROR,
                'message' => 'Only numerics are allowed.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["contact_2"])) {
            //Bypass
        } else if (!is_numeric($member["contact_2"])) {
            array_push($error, array(
                'target_block' => 11,
                'code' => ERROR,
                'message' => 'Only numerics are allowed.'
            ));
        }
        if (sizeof($error) > 0) {
            $this->_template->status('Please fill the form properly', 0, ERROR, $error);
        }

        if (!$this->_validate->isNotBlank($member["location"])) {
            //Bypass
        } else if (!$this->_validate->isAlpha($member["location"])) {
            array_push($error, array(
                'target_block' => 12,
                'code' => ERROR,
                'message' => 'Only letters are allowed.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["location_type"])) {
            array_push($error, array(
                'target_block' => 13,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!$this->_validate->isAlpha($member["location_type"])) {
            array_push($error, array(
                'target_block' => 13,
                'code' => ERROR,
                'message' => 'Only letters are allowed.'
            ));
        }
        
        if (sizeof($error) > 0) {
            $this->_template->status('Please fill the form properly', 0, ERROR, $error);
            return;
        }
       
        $member['team_id'] = $_SESSION['TEAM_ID'];
        if ($this->Member->save($member)) {//$this->Member->save($member)
            $this->_template->status('The members has been added successfully.', 0, SUCCESS);
            redirect('members/add');
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
    }

    function viewall() {
        $result = $this->Member->viewall();
        if ($result !== false) {
            $this->_template->set('member_list', $result);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
        
        $team=new Team;
        $team_list=$team->viewall();
        if ($team_list !== false) {
            $this->_template->set('team_list', $team_list);
        } else {
            $this->_template->status('Sorry,failed to load Team.', 0, WARNING);
        }
    }

    /*function view($member_id) {
        
        if(!$this->authenticated){
            redirect('account/login');
        }
        
        $result = $this->Member->view($member_id);
        if ($result !== false) {
            $this->_template->set('member', $result);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
    }*/

    function view($team_id) {
        
        
        $result = $this->Member->teamMembers($team_id);
        if ($result !== false) {
            $this->_template->set('member_list', $result);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
        
        $team=new Team;
        $team_list=$team->viewall();
        if ($team_list !== false) {
            $this->_template->set('team_list', $team_list);
        } else {
            $this->_template->status('Sorry,failed to load Team.', 0, WARNING);
        }
        
        foreach($team_list as $team){
            if($team['TEAM_ID']==$team_id){
                $this->_template->set('current_team_name', $team['NAME']);
                break;
            }
        }
    }

}

?>
