<?php

class TeamsController extends Controller {

    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        $account = new Account;
        if ($account->check_user()) {
            $this->_template->set('loggedin', true);
            $this->authenticated = true;
        }
    }

    //put your code here
    function add() {

        if (!$this->authenticated) {
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }

        if ($_SESSION['ADMIN_TYPE'] != 'PROJECT_ADMIN' && $_SESSION['ADMIN_TYPE'] != 'APP_ADMIN') {
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
        $team = $this->getRequest(INPUT_POST);
        $error = array();
        if (!$this->_validate->isNotBlank($team['team_full_name'])) {
            array_push($error, array(
                'target_block' => 1,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!$this->_validate->isAlpha($team['team_full_name'], ' ')) {
            array_push($error, array(
                'target_block' => 1,
                'code' => ERROR,
                'message' => 'Only letters are allowed.'
            ));
        }

        if (!$this->_validate->isNotBlank($team['team_short_name'])) {
            array_push($error, array(
                'target_block' => 2,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!$this->_validate->isAlpha($team['team_short_name'])) {
            array_push($error, array(
                'target_block' => 2,
                'code' => ERROR,
                'message' => 'Only letters are allowed.'
            ));
        }
        if (!$this->_validate->isNotBlank($team["team_email"])) {
            array_push($error, array(
                'target_block' => 3,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!filter_var($team["team_email"], FILTER_VALIDATE_EMAIL)) {
            array_push($error, array(
                'target_block' => 3,
                'code' => ERROR,
                'message' => 'Invalid email format.'
            ));
        }

        $team['admin_username'] = $team['team_short_name'] . 'admin';
        $password = substr(md5(time()), 0, 6);

        $account = new Account;

        for ($i = -1; $i < 10; $i++) {
            if ($account->check_username($team['admin_username'])) {
                break;
            } else {
                $team['admin_username'] = $team['team_short_name'] . 'admin' . rand(1, 100);
            }
        }
        $team['password'] = md5($password);

        if (sizeof($error) > 0) {
            $this->_template->status('Please fill the form properly', 0, ERROR, $error);
            return;
        }
        /* Save */
        if ($this->Team->add($team)) {

            $mail = "Hi " . $team['team_full_name'] . " Team,<br/><br/>"
                    . "Your account has been created successfully.Please login with below credential."
                    . "<br/><br/>"
                    . "<b>Username:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                    . $team['admin_username']
                    . "<br/>"
                    . "<b>Password:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                    . $password
                    . "<br/><br/><br/>"
                    . "Thank & Regards,<br/>"
                    . "Shift Schedule Admin<br/>"
                    . "" . PROJECT . "<br/>"
                    . "" . COMPANY . "<br/>";

            $this->Mail->sendMail($team["team_email"], "Welcome to " . PROJECT . " Shift Schedule", $mail, PROJECT_EMAIL, PROJECT . ' Shift Schedule');

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

        if (!$this->authenticated) {
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

    function remove($team_id) {

        if (!$this->authenticated) {
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }

        if ($_SESSION['ADMIN_TYPE'] != 'PROJECT_ADMIN' && $_SESSION['ADMIN_TYPE'] != 'APP_ADMIN') {
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

    public function edit($team_id = null) {
        if (!$this->authenticated) {
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }

        if ($_SESSION['ADMIN_TYPE'] != 'PROJECT_ADMIN' && $_SESSION['ADMIN_TYPE'] != 'APP_ADMIN') {
            $this->_template->status('You do not have permission to Create/Remove any Teams.', 0, ERROR);
            redirect('teams/viewall');
            return;
        }

        if (!isset($_GET['attempt']) || empty($_GET['attempt'])) {
            if (isset($team_id) && !empty($team_id)) {
                $team = $this->Team->view($team_id);
                if ($team !== false && !empty($team)) {
                    $this->_template->set("team", $team[0]);
                } else {
                    $this->_template->status('Invalid Team.Please check.', 0, ERROR);
                    redirect("teams/viewall");
                }
            }
            return;
        }

        if (!isset($_POST) || empty($_POST)) {
            $this->_template->status('Invalid form submission.', 0, ERROR);
            return;
        }

        if (isset($_POST['team_id']) && !empty($_POST['team_id'])) {
            //   $this->_template->set("team",$this->fetch($team_id));            
        } else {
            $this->_template->status('Sorry,invalid update request.', 0, ERROR);
            redirect("teams/viewall");
        }

        $team = $this->getRequest(INPUT_POST);
        $error = array();
        if (!$this->_validate->isNotBlank($team['team_full_name'])) {
            array_push($error, array(
                'target_block' => 1,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!$this->_validate->isAlpha($team['team_full_name'], ' ')) {
            array_push($error, array(
                'target_block' => 1,
                'code' => ERROR,
                'message' => 'Only letters are allowed.'
            ));
        }

        if (!$this->_validate->isNotBlank($team['team_short_name'])) {
            array_push($error, array(
                'target_block' => 2,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!$this->_validate->isAlpha($team['team_short_name'])) {
            array_push($error, array(
                'target_block' => 2,
                'code' => ERROR,
                'message' => 'Only letters are allowed.'
            ));
        }
        if (!$this->_validate->isNotBlank($team["team_email"])) {
            array_push($error, array(
                'target_block' => 3,
                'code' => ERROR,
                'message' => 'Can\'t be blank.'
            ));
        } else if (!filter_var($team["team_email"], FILTER_VALIDATE_EMAIL)) {
            array_push($error, array(
                'target_block' => 3,
                'code' => ERROR,
                'message' => 'Invalid email format.'
            ));
        }

        if (sizeof($error) > 0) {
            $this->_template->status('Please fill the form properly', 0, ERROR, $error);
            return;
        }

        /* Save */
        if ($this->Team->update($team)) {
            $this->_template->status('Team has been updated successfully.', 0, SUCCESS);
            redirect("teams/viewall");
        } else {
            $this->_template->status('Server problem. Please try again soon.', 0, SERVER_PROBLEM);
        }
    }

}
