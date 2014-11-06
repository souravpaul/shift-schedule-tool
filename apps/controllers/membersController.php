<?php

class MembersController extends Controller {

//	public  $authenticated=false;
    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        $account = new Account;
        if ($account->check_user()) {
            $this->_template->set('loggedin', true);
            $this->authenticated = true;
        }
    }

    function viewall() {
        $result = $this->Member->viewall();
        if ($result !== false) {
            $this->_template->set('member_list', $result);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }

        $team = new Team;
        $team_list = $team->viewall();
        if ($team_list !== false) {
            $this->_template->set('team_list', $team_list);
        } else {
            $this->_template->status('Sorry,failed to load Team.', 0, WARNING);
        }
    }

    /* function view($member_id) {

      if(!$this->authenticated){
      redirect('account/login');
      }

      $result = $this->Member->view($member_id);
      if ($result !== false) {
      $this->_template->set('member', $result);
      } else {
      $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
      }
      } */

    function view($team_id) {


        $result = $this->Member->teamMembers($team_id);
        if ($result !== false) {
            $this->_template->set('member_list', $result);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }

        $team = new Team;
        $team_list = $team->viewall();
        if ($team_list !== false) {
            $this->_template->set('team_list', $team_list);
        } else {
            $this->_template->status('Sorry,failed to load Team.', 0, WARNING);
        }

        foreach ($team_list as $team) {
            if ($team['TEAM_ID'] == $team_id) {
                $this->_template->set('current_team_name', $team['FULL_NAME']);
                break;
            }
        }
    }

    function add() {
        if (!$this->authenticated) {
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
            return;
        }

        if ($_SESSION['ADMIN_TYPE'] == 'TEAM_MEMBER') {
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
        $member = $this->getRequest(INPUT_POST);
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
              )); */
        } else if (!$this->_validate->isAlphaNumeric($member["pj_id"])) {
            array_push($error, array(
                'target_block' => 4,
                'code' => ERROR,
                'message' => 'Only alphanumerics are allowed.'
            ));
        } else if (!$this->Member->isExists($member["pj_id"], 'PJ')) {
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
              )); */
        } else if (!filter_var($member["pj_email"], FILTER_VALIDATE_EMAIL)) {
            array_push($error, array(
                'target_block' => 5,
                'code' => ERROR,
                'message' => 'Invalid email format.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["pj_role"])) {
            //Bypass
        } else if (!$this->_validate->isAlphaNumeric($member["pj_role"], ' ')) {
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
        } else if (!$this->Member->isExists($member["cmp_id"], 'CMP')) {
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
        } else if (!$this->_validate->isAlphaNumeric($member["cmp_role"], ' ')) {
            array_push($error, array(
                'target_block' => 9,
                'code' => ERROR,
                'message' => 'Only alphanumerics are allowed.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["contact_1"])) {
            /* array_push($error, array(
              'target_block' => 10,
              'code' => ERROR,
              'message' => 'Can\'t be blank.'
              )); */
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
        $password = substr(md5(time()), 0, 6);
        $member['password'] = md5($password);
        $member['team_id'] = $_SESSION['TEAM_ID'];


        if ($_SESSION['ADMIN_TYPE'] == 'PROJECT_ADMIN' || $_SESSION['ADMIN_TYPE'] == 'APP_ADMIN') {
            $member['admin_type'] = 'PROJECT_ADMIN';
        } else {
            $member['admin_type'] = 'TEAM_MEMBER';
        }

        if ($this->Member->save($member)) {
            $mail = "Hi " . $member['fname'] . ",<br/><br/>"
                    . "Your account has been created successfully.Please login with below credential."
                    . "<br/><br/>"
                    . "<b>Username:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                    . $member['cmp_id']
                    . "<br/>"
                    . "<b>Password:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                    . $password
                    . "<br/><br/><br/>"
                    . "Thank & Regards,<br/>"
                    . "Shift Schedule Admin<br/>"
                    . "" . PROJECT . "<br/>"
                    . "" . COMPANY . "<br/>";

            $this->Mail->sendMail($member["cmp_email"], "Welcome to " . PROJECT . " Shift Schedule", $mail, PROJECT_EMAIL, PROJECT . ' Shift Schedule');

            $this->_template->status('The members has been added successfully.', 0, SUCCESS);
            redirect('members/add');
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
    }

    public function edit($member_id=null) {
        if (!$this->authenticated) {
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }

        if (!isset($_GET['attempt']) || empty($_GET['attempt'])) {
            if (isset($member_id) && !empty($member_id)) {
                $member = $this->Member->view($member_id);
                if ($member !== false && !empty($member)) {
                    $this->_template->set("member", $member[0]);
                } else {
                    $this->_template->status('Invalid member profile.Please check.', 0, ERROR);
                    redirect('members/viewall');
                }
            }
            return;
        }

        if (!isset($_POST) || empty($_POST)) {
            $this->_template->status('Invalid form submission.', 0, ERROR);
            return;
        }

        /*         * *********** Validation ************** */
        $member = $this->getRequest(INPUT_POST);
        $member_id=$member['member_id'];
        if ($_SESSION['ADMIN_TYPE'] == 'TEAM_MEMBER' && $member_id != $_SESSION['MEMBER_ID']) {
            redirect('members/viewall');
            return;
        }
        
        if($_SESSION['ADMIN_TYPE'] == 'TEAM_ADMIN'){
            $isAdmin=true;
        }else{
            $isAdmin=false;
        }
        
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
              )); */
        } else if (!$this->_validate->isAlphaNumeric($member["pj_id"])) {
            array_push($error, array(
                'target_block' => 4,
                'code' => ERROR,
                'message' => 'Only alphanumerics are allowed.'
            ));
        } else if (!$this->Member->isExists($member["pj_id"], 'PJ')) {
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
              )); */
        } else if (!filter_var($member["pj_email"], FILTER_VALIDATE_EMAIL)) {
            array_push($error, array(
                'target_block' => 5,
                'code' => ERROR,
                'message' => 'Invalid email format.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["pj_role"])) {
            //Bypass
        } else if (!$this->_validate->isAlphaNumeric($member["pj_role"], ' ')) {
            array_push($error, array(
                'target_block' => 6,
                'code' => ERROR,
                'message' => 'Only alphanumerics are allowed.'
            ));
        }

        if ($_SESSION['ADMIN_TYPE'] == 'TEAM_ADMIN') {
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
            } else if (!$this->Member->isExists($member["cmp_id"], 'CMP')) {
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
        }
        if (!$this->_validate->isNotBlank($member["cmp_role"])) {
            //Bypass
        } else if (!$this->_validate->isAlphaNumeric($member["cmp_role"], ' ')) {
            array_push($error, array(
                'target_block' => 9,
                'code' => ERROR,
                'message' => 'Only alphanumerics are allowed.'
            ));
        }

        if (!$this->_validate->isNotBlank($member["contact_1"])) {

            if ($_SESSION['ADMIN_TYPE'] == 'TEAM_MEMBER') {
                array_push($error, array(
                    'target_block' => 10,
                    'code' => ERROR,
                    'message' => 'Can\'t be blank.'
                ));
            }
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

        if ($this->Member->update($member,$isAdmin)) {
            $mail = "Hi " . $member['fname'] . ",<br/><br/>"
                    . "Your account has been updated successfully.Thank You."
                    . "<br/><br/><br/>"
                    . "Thank & Regards,<br/>"
                    . "Shift Schedule Admin<br/>"
                    . "" . PROJECT . "<br/>"
                    . "" . COMPANY . "<br/>";

            $this->Mail->sendMail($member["cmp_email"], "Welcome to " . PROJECT . " Shift Schedule", $mail, PROJECT_EMAIL, PROJECT . ' Shift Schedule');

            $this->_template->status('The members has been added successfully.', 0, SUCCESS);
            redirect('members/edit/'.$member_id);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
    }

}

?>
