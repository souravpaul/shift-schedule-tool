<?php

class AccountController extends Controller {

    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        if ($this->Account->check_user()) {
            $this->_template->set('loggedin', true);
            $this->authenticated = true;
        }
    }

    function login() {

        if ($this->authenticated) {
            redirect("account/home");
        }

        if (!isset($_GET['attempt']) || empty($_GET['attempt'])) {
            return;
        }

        if (!isset($_POST) || empty($_POST)) {
            $this->_template->status('Invalid form submission.', 0, ERROR);
            return;
        }

        /*         * *********** Validation ************** */
        $post = $this->getRequest(INPUT_POST);
        if (isset($post['username']) && !empty($post['username'])) {
            $user['username'] = $post['username'];
        } else {
            $this->_template->status('Invalid username or password.', 0, ERROR);
            return;
        }
        if (isset($post['password']) && !empty($post['password'])) {
            $user['password'] = md5($post['password']);
        } else {
            $this->_template->status('Invalid username or password.', 0, ERROR);
            return;
        }
        if ($this->Account->login($user)) {
            if ($_SESSION['PASSWORD_TYPE'] == "PART_TIME" && $_SESSION['ADMIN_TYPE'] != "APP_ADMIN") {
                redirect('account/reset_password');
            } else {
                redirect('account/home');
            }
        } else {
            $this->_template->status('Invalid username or password.', 0, ERROR);
        }
    }

    function logout() {
        $this->Account->logout();
        redirect('account/login');
    }

    function home() {
        // redirect("schedules/calender");
        /*         * ******** Create Team List ************** */
        $schedule=new Schedule;
        $team_list=$schedule->liveMembers();
        $live_track=array();
        $max_mem=0;
        if ($team_list !== false) {
            foreach ($team_list as $team){
                if(!isset($temp_team['TEAM_ID'])){
                    $temp_team=array();
                    $temp_team['TEAM_ID']=$team['TEAM_ID'];
                    $temp_team['TEAM_NAME']=$team['FULL_NAME'];
                    $max_mem=$team['MAX_MEM'];
                    $temp_team['MEMBER']=array();
                }
                else if( $temp_team['TEAM_ID']!=$team['TEAM_ID']){
                    
                    array_push($live_track, $temp_team);
                    $temp_team=array();
                    $temp_team['TEAM_ID']=$team['TEAM_ID'];
                    $temp_team['TEAM_NAME']=$team['FULL_NAME'];
                    if( $max_mem<$team['MAX_MEM']){
                         $max_mem=$team['MAX_MEM'];
                    }
                    $temp_team['MEMBER']=array();
                    
                }
                array_push($temp_team['MEMBER'], $team['FIRST_NAME'].' '.$team['LAST_NAME'] );
            }
            array_push($live_track, $temp_team);
            
            $this->_template->set('max_mem', $max_mem);
            $this->_template->set('live_track', $live_track);
        } else {
            $this->_template->status('Sorry,failed to load Team.', 0, WARNING);
        }
    }

    function isExixts($user_name) {
        
    }

    function add($user) {
        
    }

    function reset_password() {
        if (!$this->authenticated) {
            redirect("account/login");
        }

        if (!isset($_GET['attempt']) || empty($_GET['attempt'])) {
            return;
        }

        if (!isset($_POST) || empty($_POST)) {
            $this->_template->status('Invalid form submission.', 0, ERROR);
            return;
        }

        /*         * ********** Validation ************** */
        $post = $this->getRequest(INPUT_POST);
        if (isset($post['password']) && !empty($post['password'])) {
            $user['password'] = $post['password'];
        } else {
            $this->_template->status('Can\'t be blank.', 0, ERROR);
            return;
        }
        if (isset($post['conf_password']) && $post['conf_password'] == $post['password']) {
            
        } else {
            $this->_template->status('Confirm password field does not match.', 0, ERROR);
            return;
        }
        $user['user_id'] = $_SESSION["USER_ID"];

        if ($this->Account->reset_password($user)) {
            $this->_template->status('Your password has been changed successfully.', 0, SUCCESS);
            redirect('account/home');
        } else {
            $this->_template->status('Server Problem. Please try again soon.', 0, ERROR);
        }
    }

    function forget_password() {

        if (!isset($_GET['attempt']) || empty($_GET['attempt'])) {
            return;
        }

        if (!isset($_POST) || empty($_POST)) {
            $this->_template->status('Invalid form submission.', 0, ERROR);
            return;
        }

        /*         * ********** Validation ************** */
        $post = $this->getRequest(INPUT_POST);
        if (isset($post['username']) && !empty($post['username'])) {
            $user['username'] = $post['username'];
        } else {
            $this->_template->status('Can\'t be blank.', 0, ERROR);
            return;
        }
        $result = $this->Account->readUser($user['username']);
        if ($result !== false) {
            $user = $result[0];
        } else {
            $this->_template->status('Sorry,invalid username. Please check the username.', 0, ERROR);
            return;
        }


        $user['password'] = substr(md5(time()), 0, 6);

        if ($this->Account->forget_password($user)) {

            $mail = "Hi " . $user['USERNAME'] . " Team,<br/><br/>"
                    . "Your account password has been reset.Your new password is "
                    . "<br/><br/>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;"
                    . $user['password']
                    . "<br/><br/><br/>"
                    . "Thank & Regards,<br/>"
                    . "Shift Schedule Admin<br/>"
                    . "" . PROJECT . "<br/>"
                    . "" . COMPANY . "<br/>";

            $this->Mail->sendMail($user["USER_EMAIL"], PROJECT . " Shift Schedule: Account Recovery", $mail, PROJECT_EMAIL, PROJECT . ' Shift Schedule');

            $this->_template->status('New password has been sent to your mail.', 0, SUCCESS);
            redirect('account/login');
        } else {
            $this->_template->status('Server Problem. Please try again soon.', 0, ERROR);
        }
    }

}
