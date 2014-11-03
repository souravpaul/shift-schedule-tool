<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of schedulesController
 *
 * @author sourav
 */
class SchedulesController extends Controller {

    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        $account = new Account;
        if ($account->check_user()) {
            $this->_template->set('loggedin', true);
            $this->authenticated = true;
        }
    }

    function view($team_id) {
        if ((!isset($_POST) || empty($_POST)) && (!isset($_SESSION['date_save']) || empty($_SESSION['date_save']))) {
            $this->_template->status('Invalid form submission.', 0, ERROR);
            return;
        }
        if (isset($_POST['dates'])) {
            $dates = array_values(array_filter($_POST['dates']));

            foreach ($dates as $key => $date) {
                $dates[$key] = date('d-m-Y', strtotime($date));
            }

            if (empty($dates)) {
                $this->_template->status('Please choose date(s)', 0, WARNING);
                redirect('schedules/calender');
            }

            $_SESSION['date_save'] = $dates;
        } else {
            if (!isset($_SESSION['date_save']) || empty($_SESSION['date_save'])) {
                $this->_template->status('Please choose date(s) to create schedule.', 0, WARNING);
                redirect('schedules/calender');
            }
            $dates = $_SESSION['date_save'];
        }



        $weekday_dates = array();
        $weekend_dates = array();
        foreach ($dates as $date) {
            $day = date('N', strtotime($date));
            if ($day == '6' || $day == '7') {
                array_push($weekend_dates, $date);
            } else {
                array_push($weekday_dates, $date);
            }
        }

        $this->_template->set('weekday_dates', $weekday_dates);
        $this->_template->set('weekend_dates', $weekend_dates);

        /*         * ********** Create Team List ************** */
        $team = new Team;
        $team_list = $team->viewall();
        if ($team_list !== false) {
            $this->_template->set('team_list', $team_list);
        } else {
            $this->_template->status('Sorry,failed to load Team.', 0, WARNING);
        }

        /*         * **************  Shift List  ***************** */
        $this->_template->set('current_team', $team_id);
        $shift = new Shift;
        $shift_list = $shift->view($team_id);
        if ($shift_list !== false) {
            $this->_template->set('shift_list', $shift_list);
        } else {
            $this->_template->status('Sorry,failed to load Team.', 0, WARNING);
        }

        /*         * ***** Schedule List ****** */
        $result = $this->Schedule->view($team_id, $dates);
        $schedule_list = array();
        if ($result !== false) {

            foreach ($result as $row) {
                $schedule_list["'" . $row['DATE'] . "'"][$row['SHIFT_ID']][$row['RANK']] = $row;
            }
            $this->_template->set('schedule_list', $schedule_list);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.' . $this->Schedule->getError(), 0, ERROR);
        }


        foreach ($team_list as $team) {
            if ($team['TEAM_ID'] == $team_id) {
                $this->_template->set('current_team_name', $team['NAME']);
                break;
            }
        }

        $dates = '"' . implode('","', $dates) . '"';
    }

    function calender() {
        unset($_SESSION['date_save']);
    }

    function create() {

        if (!$this->authenticated) {
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }

        if ((!isset($_POST) || empty($_POST)) && (!isset($_SESSION['date_save']) || empty($_SESSION['date_save']))) {
            $this->_template->status('Please choose date(s) to create schedule.', 0, WARNING);
            redirect('schedules/calender');
        }
        
        $team_id = $_SESSION['TEAM_ID'];

        $dates = $_SESSION['date_save'];
        
        foreach($dates as $date){
            if(strtotime($date) <strtotime(date('d-m-Y'))){
                $this->_template->status('You cannot updated old days schedule.', 0, ERROR);
                redirect('schedules/view/'.$team_id);                
            }
        }

        $weekday_dates = array();
        $weekend_dates = array();
        foreach ($dates as $date) {
            $day = date('N', strtotime($date));
            if ($day == '6' || $day == '7') {
                array_push($weekend_dates, $date);
            } else {
                array_push($weekday_dates, $date);
            }
        }

        $this->_template->set('weekday_dates', $weekday_dates);
        $this->_template->set('weekend_dates', $weekend_dates);

        /*         * ********** Create Team member List ************** */
        $member = new Member;
        $member_list = $member->teamMembers($team_id);
        if ($member_list !== false) {
            $this->_template->set('member_list', $member_list);
        } else {
            $this->_template->status('Sorry,failed to load Team member.', 0, WARNING);
        }

        /*         * **************  Shift List  ***************** */
        $this->_template->set('current_team', $team_id);
        $shift = new Shift;
        $shift_list = $shift->view($team_id);
        if ($shift_list !== false) {
            $this->_template->set('shift_list', $shift_list);
        } else {
            $this->_template->status('Sorry,failed to load Team.', 0, WARNING);
        }

        /*         * ***** Schedule List ****** */
        $result = $this->Schedule->view($team_id, $dates);
        $schedule_list = array();
        if ($result !== false) {

            foreach ($result as $row) {
                $schedule_list["'" . $row['DATE'] . "'"][$row['SHIFT_ID']][$row['RANK']] = $row;
            }
            $this->_template->set('schedule_list', $schedule_list);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.' . $this->Schedule->getError(), 0, ERROR);
        }



        $dates = '"' . implode('","', $dates) . '"';
    }

    function add() {
        if (!$this->authenticated) {
            $this->_template->status('Please login.', 0, ERROR);
            redirect('account/login');
        }

        if ((!isset($_POST) || empty($_POST)) && (!isset($_SESSION['date_save']) || empty($_SESSION['date_save']))) {
            $this->_template->status('Invalid form submission.', 0, ERROR);
            return;
        }
        $schedule = $_POST['schedule'];
        $shift_schedule = array();

        foreach ($schedule as $key => $value) {
            foreach ($value as $sub_key => $sub_value) {
                foreach ($sub_value as $end_key => $end_value) {
                    if (empty($end_value))
                        continue;
                    array_push($shift_schedule, array(
                        'date' => $key,
                        'shift_id' => $sub_key,
                        'rank' => $end_key,
                        'member_id' => $end_value
                    ));
                }
            }
        }
        if ($this->Schedule->add($shift_schedule)) {
            $this->_template->status('Schedule has been updated successfully.', 0, SUCCESS);
            redirect('schedules/view/' . $_SESSION['TEAM_ID']);
            return;
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
        //s $this->_template->status(json_encode($shift_schedule), 0, WARNING);
        redirect('schedules/create');
    }

}
