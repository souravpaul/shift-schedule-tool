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
        
        if(isset($_GET['ref']) && $_GET['ref']=="today"){
            $_SESSION['date_save']=array(date('d-m-Y'));
        }        
        else if ((!isset($_POST) || empty($_POST)) && (!isset($_SESSION['date_save']) || empty($_SESSION['date_save']))) {
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
            print_r($dates);
        }
        $this->_template->set('current_team', $team_id);

        /*         * ******** Create Team List ************** */
        $team = new Team;
        $team_list = $team->viewall();
        if ($team_list !== false) {
            $this->_template->set('team_list', $team_list);
        } else {
            $this->_template->status('Sorry,failed to load Team.', 0, WARNING);
        }


        /*         * *** Schedule List ****** */
        $result = $this->Schedule->view($team_id, $dates);
        if ($result !== false) {
            $formats = array();
            $schedule_list = array();
            $temp_schedule = array();
            $temp_format = array();
            $temp_date = "";
            $count = 0;
            $max_member = 0;

            foreach ($result as $row) {
                // echo '<br/ >' . $temp_date . ' - - - - ' . $row['DATE'];
                if (strlen($temp_date) < 5) {
                    $temp_date = $row['DATE'];
                } else if ($temp_date != $row['DATE']) {

                    $temp_block = array();
                    $temp_block[$temp_date]['shift'] = $temp_schedule;

                    $pos = array_search($temp_format, $formats);
                    if ($pos === false) {
                        //   echo '<br/> Inserted ' . $count;
                        array_push($formats, $temp_format);
                        $schedule_list[$count] = array();
                        $schedule_list[$count][$temp_date]['shift'] = $temp_schedule;
                        $schedule_list[$count++][$temp_date]['max_mem'] = $max_member;
                    } else {
                        //echo '<br/> reinserted ', $pos;
                        $schedule_list[$pos][$temp_date]['shift'] = $temp_schedule;
                        $schedule_list[$pos][$temp_date]['max_mem'] = $max_member;
                        // $schedule_list[$pos] = $temp_block;
                    }

                    $temp_date = $row['DATE'];
                    $temp_format = array();
                    $temp_schedule = array();
                    $max_member = 0;
                }
                if (!in_array(array(
                            'id' => $row['SHIFT_ID'],
                            'start' => "" . date('g A', strtotime($row['START_TIME'])),
                            'end' => date('g A', strtotime($row['END_TIME']))
                                ), $temp_format)) {
                    array_push($temp_format, array(
                        'id' => $row['SHIFT_ID'],
                        'start' => "" . date('g A', strtotime($row['START_TIME'])),
                        'end' => date('g A', strtotime($row['END_TIME']))
                    ));
                    if ($row['MAX_MEM'] > $max_member) {
                       // echo '<br/>'.$row['MAX_MEM'].' > '.$max_member.' > > '.$row['DATE'];
                        $max_member = $row['MAX_MEM'];
                    }
                    //  $temp_schedule[$temp_count]=array())
                }
                array_push($temp_schedule, $row);
            }

            $temp_block = array();
            $pos = array_search($temp_format, $formats);
            if ($pos === false) {
                array_push($formats, $temp_format);
                $schedule_list[$count] = array();
                $schedule_list[$count][$temp_date]['shift'] = $temp_schedule;
                $schedule_list[$count++][$temp_date]['max_mem'] = $max_member;
            } else {
                $schedule_list[$pos][$temp_date]['shift'] = $temp_schedule;
                $schedule_list[$pos][$temp_date]['max_mem'] = $max_member;
            }


         /*   foreach ($schedule_list as $key => $value) {

                echo '<br/><br/>' . $key . '  =>  ' . $value . '';
                foreach ($value as $key1 => $value1) {
                    echo '<br/> &nbsp; &nbsp; &nbsp;   ' . $key1 . '  =>  ' . $value1 . '';
                    foreach ($value1 as $key2 => $value2) {
                        echo '<br/> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;   ' . $key2 . '  =>  ' . $value2 . '';
                     /*   foreach ($value2 as $key3 => $value3) {
                            echo '<br/> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;   ' . $key3 . '  =>  ' . $value3 . '';
                        }
                    }
                }
                echo '<br/><br/>';
            }*/

            $this->_template->set('schedule_list', $schedule_list);
            $this->_template->set('formats', $formats);
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.' . $this->Schedule->getError(), 0, ERROR);
        }


        foreach ($team_list as $team) {
            if ($team['TEAM_ID'] == $team_id) {
                $this->_template->set('current_team_name', $team['FULL_NAME']);
                break;
            }
        }

        $dates = '"' . implode('","', $dates) . '"';
    }

    function calender() {
        unset($_SESSION['date_save']);
        /*         * ********** Create Team List ************** */
        $team = new Team;
        $team_list = $team->viewall();
        if ($team_list !== false) {
            $this->_template->set('team_list', $team_list);
        } else {
            $this->_template->status('Sorry,failed to load Team.', 0, WARNING);
        }
        /******** Create date list *****/
        $result=$this->Schedule->readDates();
      
        $this->_template->set('edited_date_list', $result);
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
       
        $date_list=array();
        foreach ($dates as $date) {
            if (strtotime($date) < strtotime(date('d-m-Y'))) {
            }else{
                array_push($date_list, $date);
            }
        }
      
        if(sizeof($date_list)==0){
                $this->_template->status('You cannot updated old days schedule.', 0, ERROR);
                redirect('schedules/view/' . $team_id);            
        }
        

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

        $team_model = new Team;
        $team_result = $team_model->view($team_id);
        if ($team_result !== false && !empty($team_result)) {
            $this->_template->set('current_team_name', $team_result[0]['FULL_NAME']);
        }

        /*         * ***** Schedule List ****** */
        $result = $this->Schedule->insertSchedule($date_list);
        $result = $this->Schedule->view($team_id, $date_list);
        if ($result !== false) {

            $formats = array();
            $schedule_list = array();
            $temp_schedule = array();
            $temp_format = array();
            $temp_date = "";
            $count = 0;
            $temp_count = 0;
           
            $max_member = 0;
            foreach ($result as $row) {
                $temp_schedule_list["'" . $row['DATE'] . "'"][$row['SHIFT_ID']][$row['RANK']] = $row;
                // echo '<br/ >' . $temp_date . ' - - - - ' . $row['DATE'];
                if (strlen($temp_date) < 5) {
                    $temp_date = $row['DATE'];
                } else if ($temp_date != $row['DATE']) {

                    $temp_block = array();
                    $temp_block[$temp_date]['shift'] = $temp_schedule;

                    $pos = array_search($temp_format, $formats);
                    if ($pos === false) {
                        //   echo '<br/> Inserted ' . $count;
                        array_push($formats, $temp_format);
                        $schedule_list[$count] = array();
                        $schedule_list[$count][$temp_date]['shift'] = $temp_schedule;
                        $schedule_list[$count++][$temp_date]['max_mem'] = $max_member;
                    } else {
                        //echo '<br/> reinserted ', $pos;
                        $schedule_list[$pos][$temp_date]['shift'] = $temp_schedule;
                        $schedule_list[$pos][$temp_date]['max_mem'] = $max_member;
                        // $schedule_list[$pos] = $temp_block;
                    }

                    $temp_date = $row['DATE'];
                    $temp_format = array();
                    $temp_schedule = array();
                }
                if (!in_array(array(
                            'id' => $row['SHIFT_ID'],
                            'start' => "" . date('g A', strtotime($row['START_TIME'])),
                            'end' => date('g A', strtotime($row['END_TIME']))
                                ), $temp_format)) {
                    array_push($temp_format, array(
                        'id' => $row['SHIFT_ID'],
                        'start' => "" . date('g A',  strtotime($row['START_TIME'])),
                        'end' => date('g A', strtotime($row['END_TIME']))
                    ));
                    if ($row['MAX_MEM'] > $max_member) {
                        $max_member = $row['MAX_MEM'];
                    }
                    //  $temp_schedule[$temp_count]=array())
                }
                array_push($temp_schedule, $row);
            }

            $temp_block = array();
            $pos = array_search($temp_format, $formats);
            if ($pos === false) {
                array_push($formats, $temp_format);
                $schedule_list[$count] = array();
                $schedule_list[$count][$temp_date]['shift'] = $temp_schedule;
                $schedule_list[$count++][$temp_date]['max_mem'] = $max_member;
            } else {
                $schedule_list[$pos][$temp_date]['shift'] = $temp_schedule;
                $schedule_list[$pos][$temp_date]['max_mem'] = $max_member;
            }
            $this->_template->set('schedule_list', $schedule_list);
            $this->_template->set('formats', $formats);
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
    
    function clear(){
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
        $date_list=array();
        foreach ($dates as $date) {
            if (strtotime($date) < strtotime(date('d-m-Y'))) {
            }else{
                array_push($date_list, $date);
            }
        }
        if(sizeof($date_list)==0){
                $this->_template->status('You cannot updated old days schedule.', 0, ERROR);
                redirect('schedules/view/' . $team_id);            
        }
        
        if ($this->Schedule->clearSchedule($date_list)) {
            $this->_template->status('Schedule has been cleared.', 0, SUCCESS);
            redirect('schedules/calender');
            return;
        } else {
            $this->_template->status('Sorry,server problem.Please try again soon.', 0, ERROR);
        }
    }

}
