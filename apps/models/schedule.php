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
            array_push($date_list, $shift['date']);
            /*  array_push($shift_list, $shift['shift_id']);
              array_push($rank_list, $shift['rank']);
              array_push($member_list, $shift['member_id']); */
        }
        $date_list_string = '( ' . rtrim(implode(',', $date_list), ",") . ' )';
        
        $sql = "SELECT * FROM SCHEDULE WHERE TEAM_ID='".$_SESSION['TEAM_ID']."' AND DATE IN " . $date_list_string;
        $result = $this->fetch($sql);
        $update_condition = "";
        $insert_data = "";
        $schedule_string=array();
        $schedule_ids=array();
        $update_in=array();
        
        if ($result !== false) {
           // print_R($result);
            foreach ($result as $row) {
                array_push($schedule_string, $row['DATE'].'-'.$row['SHIFT_ID'].'-'.$row['RANK']);
                array_push($schedule_ids, $row['SCH_ID']);
            }
        }

        foreach ($shift_schedule as $shift) {
            $q_string = str_replace("'","",$shift['date'].'-'.$shift['shift_id'].'-'.$shift['rank']);
           
            $pos=array_search($q_string, $schedule_string);
            if ($pos !== FALSE) {
                array_push($update_in, $schedule_ids[$pos]);
                $update_condition.=' WHEN ' . $schedule_ids[$pos] . ' THEN ' . $shift['member_id'];
            } else {
                $insert_data.='( ' . $shift['date'] . ',' . $shift['shift_id'] . ',' . $shift['rank'] . ',' . $shift['member_id'] .','.$_SESSION['TEAM_ID']. ') , ';
            }
        }

        if (strlen($insert_data) > 0) {
            $sql = "INSERT INTO SCHEDULE (DATE,SHIFT_ID,RANK,MEMBER_ID,TEAM_ID) "
                    . "VALUES " . rtrim($insert_data, " ,");
            $insert_result=$this->query($sql);
            echo '<br/>'.$sql;
        }else{
            $insert_result=true;
        }

        if (strlen($update_condition) > 0) {
            $sql = "UPDATE SCHEDULE SET MEMBER_ID= CASE SCH_ID "
                    . $update_condition
                    . ' END'
                    . ' WHERE SCH_ID IN ( ' . rtrim(implode(',', $update_in),",") . ' )';
           $update_result=$this->query($sql);
        }else{
            $update_result=true;
        }
        return ($insert_result && $update_result);
    }
    
    function view($team_id,$date_list){
    /*    $sql="SELECT * FROM ("
                . " (SELECT * FROM SCHEDULE WHERE TEAM_ID='$team_id') A "
                . " LEFT JOIN"
                . " (SELECT * FROM MEMBER) B"
                . " ON B.MEM_ID=A.MEMBER_ID"
                . " LEFT JOIN"
                . " (SELECT START_TIME,STRUCT_ID FROM SHIFT_STRUCTURE) C"
                . " ON A.SHIFT_ID=C.STRUCT_ID)"
                . " ORDER BY C.START_TIME ASC";//ORDER BY STR_TO_DATE(A.DATE,'%d-%m-%Y') ASC,*/ 
        
       
        $sql_help= "'". implode("','",$date_list)."'";
        
        $sql="SELECT * FROM ("
                . " (SELECT * FROM SCHEDULE WHERE TEAM_ID='$team_id' AND DATE IN ($sql_help) ) A "
                . " LEFT JOIN"
                . " (SELECT * FROM MEMBER) B"
                . " ON B.MEM_ID=A.MEMBER_ID)"
                . " ORDER BY STR_TO_DATE(A.DATE,'%d-%m-%Y') ASC";//ORDER BY ,
        $result=$this->fetch($sql);
       
        return $result;
    }

}
