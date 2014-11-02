<?php

class Shift extends Model{
    function add($structure){
        $sql = 'INSERT INTO SHIFT_STRUCTURE (START_TIME,END_TIME,SHIFT_TYPE,SHIFT_DAYS,TEAM_ID) '
                . 'VALUES("'.mktime($structure["start_time"],0,0).'","'.mktime($structure["end_time"],0,0).'","'.$structure["shift_type"].'",'
                . '"'.$structure["shift_days"].'","'.$structure["team_id"].'")';
        $result = $this->query($sql);
        //echo $structure["start_time"].' '.mktime($structure["start_time"]).' '.  mktime(1);
       // return false;
        return $result;
    }
    
    function view($team_id){
        $sql = 'SELECT * FROM SHIFT_STRUCTURE WHERE TEAM_ID="' . $team_id . '" AND ACTIVE="1" ORDER BY START_TIME';
        $result = $this->fetch($sql);
        return $result;
    }
    
    function update($structure){
        
    }
    
    function remove($shift_id){
        $sql="UPDATE SHIFT_STRUCTURE SET ACTIVE='0' WHERE STRUCT_ID='$shift_id' AND TEAM_ID='".$_SESSION['TEAM_ID']."'";
	$result=$this->query($sql);	
	return $result;
    }
}
