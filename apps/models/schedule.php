<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of schedule
 *
 * @author sourav
 */
class Schedule extends Model {

    //put your code here

    function add($shift_schedule) {

        $date_list = array();

        foreach ($shift_schedule as $shift) {
            if (!in_array($shift['date'], $date_list)) {
                array_push($date_list, $shift['date']);
            }
        }
        // echo'<br></br>';
        //$this->insertSchedule($date_list);

        $date_list_string = '( ' . rtrim(implode(',', $date_list), ",") . ' )';

        $sql = "SELECT * FROM SCHEDULE WHERE TEAM_ID='" . $_SESSION['TEAM_ID'] . "' AND DATE IN " . $date_list_string;
        $result = $this->fetch($sql);
        $update_condition = "";
        $schedule_string = array();
        $schedule_ids = array();
        $update_in = array();

        if ($result !== false) {
            // print_R($result);
            foreach ($result as $row) {
                array_push($schedule_string, $row['DATE'] . '-' . $row['SHIFT_ID'] . '-' . $row['RANK']);
                array_push($schedule_ids, $row['SCH_ID']);
            }
        }

        foreach ($shift_schedule as $shift) {
            $q_string = str_replace("'", "", $shift['date'] . '-' . $shift['shift_id'] . '-' . $shift['rank']);

            $pos = array_search($q_string, $schedule_string);
            if ($pos !== FALSE) {
                array_push($update_in, $schedule_ids[$pos]);
                $update_condition.=' WHEN ' . $schedule_ids[$pos] . ' THEN ' . $shift['member_id'];
            }
        }



        if (strlen($update_condition) > 0) {
            $sql = "UPDATE SCHEDULE SET MEMBER_ID= CASE SCH_ID "
                    . $update_condition
                    . ' END'
                    . ' WHERE SCH_ID IN ( ' . rtrim(implode(',', $update_in), ",") . ' )';
            $update_result = $this->query($sql);
        } else {
            $update_result = true;
        }
        return ($update_result);
    }

    function view($team_id, $date_list) {
        /*    $sql="SELECT * FROM ("
          . " (SELECT * FROM SCHEDULE WHERE TEAM_ID='$team_id') A "
          . " LEFT JOIN"
          . " (SELECT * FROM MEMBER) B"
          . " ON B.MEM_ID=A.MEMBER_ID"
          . " LEFT JOIN"
          . " (SELECT START_TIME,STRUCT_ID FROM SHIFT_STRUCTURE) C"
          . " ON A.SHIFT_ID=C.STRUCT_ID)"
          . " ORDER BY C.START_TIME ASC";//ORDER BY STR_TO_DATE(A.DATE,'%d-%m-%Y') ASC, */

        $sql_help = "'" . implode("','", $date_list) . "'";

        $sql = "SELECT * FROM ("
                . " (SELECT * FROM SCHEDULE WHERE TEAM_ID='$team_id' AND DATE IN ($sql_help) ) A "
                . " LEFT JOIN"
                . " (SELECT MEM_ID,FIRST_NAME,LAST_NAME FROM MEMBER) B"
                . " ON B.MEM_ID=A.MEMBER_ID"
                . " LEFT JOIN"
                . " (SELECT STRUCT_ID,SHIFT_DAYS,START_TIME,END_TIME,MAX_MEM FROM SHIFT_STRUCTURE) C"
                . " ON C.STRUCT_ID=A.SHIFT_ID)"
                . " ORDER BY STR_TO_DATE(A.DATE,'%d-%m-%Y'),TIME(C.START_TIME) ASC "; //ORDER BY ,
        $result = $this->fetch($sql);

        return $result;
    }

    function insertSchedule($dates) {
        $date_array = array();
        foreach ($dates as $date) {
            if (!in_array("'" . $date . "'", $date_array)) {
                array_push($date_array, "'" . $date . "'");
            }
        }

        $shift_model = new Shift;
        $shift_list = $shift_model->view($_SESSION['TEAM_ID']);
        $max_rank = 0;
        foreach ($shift_list as $shift) {
            if ($shift['MAX_MEM'] > $max_rank) {
                $max_rank = $shift['MAX_MEM'];
            }
        }

        $sql = "SELECT DISTINCT DATE FROM SCHEDULE WHERE TEAM_ID='" . $_SESSION['TEAM_ID'] . "' AND DATE IN (" . rtrim(implode(',', $date_array)) . ")";
        $date_array_select = array();

        $result = $this->fetch($sql);
        if ($result !== false) {
            foreach ($result as $row) {
                array_push($date_array_select, "'" . $row['DATE'] . "'");
            }
        }


        $date_array = array_diff($date_array, $date_array_select);


        $rank_insert_data = "";
        for ($i = 1; $i <= $max_rank; $i++) {
            $rank_insert_data.="( '<#DATE>',"
                    . " '<#STRUCT_ID>',"
                    . " '$i',"
                    . " 0,"
                    . " '" . $_SESSION['TEAM_ID'] . "'"
                    . " ),<#$i>";
        }
        //echo "<b>rank_insert_data:</b> <br/>$rank_insert_data <br/> <br/> <br/>";

        $shift_insert_data_weekday = "";
        $shift_insert_data_weekend = "";
        $shift_insert_data_both = "";
        foreach ($shift_list as $shift) {
            $pos = strpos($rank_insert_data, "<#" . $shift['MAX_MEM'] . ">");
            $temp = substr($rank_insert_data, 0, $pos - 1);
            $temp = preg_replace('(<#[0-9]+>)', '', $temp);
            $temp = str_replace("<#STRUCT_ID>", $shift['STRUCT_ID'], $temp);
            if (strtoupper($shift['SHIFT_DAYS']) == 'BOTH') {
                $shift_insert_data_both.=',' . $temp;
            } else if (strtoupper($shift['SHIFT_DAYS']) == 'WEEKEND') {
                $shift_insert_data_weekend.=',' . $temp;
            } else if (strtoupper($shift['SHIFT_DAYS']) == 'WEEKDAY') {
                $shift_insert_data_weekday.=',' . $temp;
            }
        }
        /*  echo "<b>shift_insert_data_both:</b> <br/>$shift_insert_data_both <br/> <br/> <br/>";
          echo "<b>shift_insert_data_weekend:</b> <br/>$shift_insert_data_weekend <br/> <br/> <br/>";
          echo "<b>shift_insert_data_weekday:</b> <br/>$shift_insert_data_weekday <br/> <br/> <br/>"; */

        $insert_date = "";
        foreach ($date_array as $date) {

            $temp_date = strtotime(str_replace("'", "", $date));

            if (date('w', $temp_date) == 0 || date('w', $temp_date) == 6) {

                $insert_date.=str_replace('<#DATE>', str_replace("'", "", $date), $shift_insert_data_weekend);
            } else {
                $insert_date.=str_replace('<#DATE>', str_replace("'", "", $date), $shift_insert_data_weekday);
            }
            $insert_date.=str_replace('<#DATE>', str_replace("'", "", $date), $shift_insert_data_both);
        }
          //echo "<b>insert_data:</b> <br/>$insert_date <br/> <br/> <br/>";


        $sql = "INSERT INTO SCHEDULE (DATE,SHIFT_ID,RANK,MEMBER_ID,TEAM_ID) "
                . "VALUES " . ltrim($insert_date, ',');

        //echo $sql;

        if (strlen($insert_date) > 3) {
            return $this->query($sql);
        }
    }

    function clearSchedule($dates) {
        $date_array = array();
        foreach ($dates as $date) {
            if (!in_array("'" . $date . "'", $date_array)) {
                array_push($date_array, "'" . $date . "'");
            }
        }
        $sql = "DELETE FROM SCHEDULE WHERE TEAM_ID='" . $_SESSION['TEAM_ID'] . "' AND DATE IN (" . rtrim(implode(',', $date_array)) . ")";
        return $this->query($sql);
    }

    function readDates() {
        if (!isset($_SESSION['TEAM_ID']))
            return array();
        $sql = "SELECT DISTINCT DATE FROM SCHEDULE WHERE TEAM_ID='" . $_SESSION['TEAM_ID'] . "'";
        return $this->fetch($sql);
    }

    function liveMembers() {
        $today = date('d-m-Y');
        $yesterday = date('d-m-Y', strtotime('Yesterday'));
        $sql = "SELECT * FROM(
(SELECT TEAM_ID AS T_ID,MEM_ID,FIRST_NAME,LAST_NAME,MAX_MEM FROM(
(SELECT TEAM_ID,MEMBER_ID,MAX_MEM FROM(
(SELECT DATE,SHIFT_ID,TEAM_ID,MEMBER_ID FROM SCHEDULE WHERE DATE IN ('$today','$yesterday')) A
LEFT JOIN
(SELECT START_TIME,END_TIME,STRUCT_ID,MAX_MEM FROM SHIFT_STRUCTURE WHERE ACTIVE=1)  B
ON A.SHIFT_ID=B.STRUCT_ID)
WHERE (A.DATE='$today' AND CURRENT_TIME>TIME(B.START_TIME) AND CURRENT_TIME<TIME(B.END_TIME) )
    || (A.DATE='$today' AND TIME(B.START_TIME)>TIME(B.END_TIME) AND CURRENT_TIME>TIME(B.START_TIME)  )
|| (A.DATE='$yesterday' AND TIME(B.START_TIME)>TIME(B.END_TIME) AND CURRENT_TIME<TIME(B.END_TIME))) C
LEFT JOIN 
(SELECT MEM_ID,FIRST_NAME,LAST_NAME FROM MEMBER WHERE ACTIVE=1) D
ON C.MEMBER_ID=D.MEM_ID)) E
RIGHT JOIN
(SELECT TEAM_ID,FULL_NAME FROM TEAM WHERE ACTIVE=1) F
ON E.T_ID=F.TEAM_ID) ORDER BY TEAM_ID ASC";
        //echo $sql;
        return $this->fetch($sql);
    }

}
