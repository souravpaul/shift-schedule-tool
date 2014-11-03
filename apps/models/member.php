<?php

class Member extends Model {

    function save($member) {
        $sql = "INSERT INTO MEMBER
				(FIRST_NAME,MIDDLE_NAME,LAST_NAME,CMP_ROLE,PJ_ROLE,CMP_EMAIL,PJ_EMAIL,CONTACT_1,CONTACT_2,CMP_ID,PJ_ID,TEAM_ID,LOCATION,LOCATION_TYPE) 
				VALUES('" . $member['fname'] . "','" . $member['mname'] . "','" . $member['lname'] . "','" . $member['cmp_role'] . "','" . $member['pj_role'] . "','" . $member['cmp_email'] . "','" . $member['pj_email'] . "',
				'" . $member['contact_1'] . "','" . $member['contact_2'] . "','" . $member['cmp_id'] . "','" . $member['pj_id'] . "','" . $member['team_id'] . "',"
                . "         '" . $member['location'] . "','" . $member['location_type'] . "')";
        $result = $this->query($sql);

        return $result;
    }

    function view($member_id) {
        $result = $this->fetch("SELECT * FROM MEMBER WHERE MEM_ID='" . $member_id . "'");
        return $result;
    }

    function viewAll() {
        //$result = $this->fetch("SELECT * FROM MEMBER");
        $result = $this->fetch("SELECT * FROM (
				(SELECT * FROM MEMBER WHERE ACTIVE=1) A
				INNER JOIN
				(SELECT TEAM_ID AS T_ID,NAME AS TEAM_NAME FROM TEAM WHERE ACTIVE=1) B
				ON A.TEAM_ID=B.T_ID)");
        return $result;
    }

    function teamMembers($team_id) {
        $sql="SELECT * FROM ("
                . " (SELECT * FROM MEMBER WHERE TEAM_ID='" . $team_id . "' AND ACTIVE=1) A"
                . " LEFT JOIN"
                . " (SELECT TEAM_ID AS T_ID,NAME AS TEAM_NAME FROM TEAM WHERE TEAM_ID='" . $team_id . "') B"
                . " ON A.TEAM_ID=B.T_ID)";
       // $result = $this->fetch("SELECT * FROM MEMBER WHERE TEAM_ID='" . $team_id . "'");
        $result = $this->fetch($sql);
        return $result;
    }

    function update($member) {
        $sql = "UPDATE MEMBER SET NAME='" . $member['name'] . "',CMP_ROLE='" . $member['cmp_role'] . "',PJ_ROLE'" . $member['pj_role'] . "',"
                . "CMP_EMAIL='" . $member['cmp_email'] . "',PJ_EMAIL='" . $member['pj_email'] . "',"
                . "CONTACT_1='" . $member['contact_1'] . "',CONTACT_2='" . $member['contact_2'] . "',CMP_ID='" . $member['cmp_id'] . "'"
                . ",PJ_ID='" . $member['pj_id'] . "',TEAM_ID='" . $member['team_id'] . "' "
                . "WHERE MEM_ID='" . $member['mem_id'] . "' AND ACTIVE=1";
        $result = $this->fetch($sql);
        return $result;
    }

    function remove($member_id) {
        $sql = "UPDATE MEMBER SET ACTIVE='0' WHERE MEM_ID='$member_id'";
        $result = $this->fetch($sql);
        return $result;
    }

    function removeByTeam($team_id) {
        $sql = "UPDATE MEMBER SET ACTIVE='0' WHERE TEAM_ID='$team_id'";
        $result = $this->fetch($sql);
        return $result;
    }

    function isExists($id, $id_type) {
        $sql = "SELECT COUNT(MEM_ID) AS NO FROM MEMBER WHERE " . strtoupper($id_type) . "_ID='$id' AND ACTIVE=1";
        $result = $this->fetch($sql);
        if ($result !== false) {
            foreach ($result as $account) {
                if ($account['NO'] > 0) {
                    return false;
                }
                return true;
            }
        }
        return false;
    }

}

?>
