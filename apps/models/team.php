<?php

class Team extends Model {

    public function add($team) {
        $sql = 'INSERT INTO TEAM (FULL_NAME,SHORT_NAME) '
                . 'VALUES("' . $team['team_full_name'] . '","' . $team['team_short_name'] . '")';
        $result = $this->query($sql);
        
        $account=new Account();
        $user=array(
            'username'=> $team['admin_username'],
            'password'=> $team['password'],
            'team_id'=>  $this->getInsertId(),
            'admin_type'=> 'TEAM_ADMIN',
            'user_email'=> $team['team_email']
        );
        $result_acc=$account->addUser($user);
        if($result_acc!==false){
          //  echo 'right '.json_encode($user);
        }else{
           // echo 'wrong '.json_encode($user);
        }
        return ($result && $result_acc);
    }

    public function viewall() {
        $sql = 'SELECT * FROM( '
                . '(SELECT FULL_NAME,SHORT_NAME,TEAM_ID AS T_ID FROM TEAM WHERE ACTIVE=1) A '
                . 'LEFT JOIN'
                . '(SELECT * FROM ACCOUNT WHERE ADMIN_TYPE IN ("TEAM_ADMIN","APP_ADMIN")) B '
                . 'ON A.T_ID=B.TEAM_ID) ';
        $result = $this->fetch($sql);
       // die($sql);
        return $result;
    }

    public function view($team_id) {
        //$sql = 'SELECT * FROM TEAM WHERE TEAM_ID="' . $team_id . '" AND ACTIVE=1';
        $sql = 'SELECT * FROM( '
                . '(SELECT FULL_NAME,SHORT_NAME,TEAM_ID AS T_ID FROM TEAM WHERE ACTIVE=1 AND TEAM_ID="' . $team_id . '") A '
                . 'LEFT JOIN'
                . '(SELECT * FROM ACCOUNT WHERE ADMIN_TYPE IN ("TEAM_ADMIN","APP_ADMIN")) B '
                . 'ON A.T_ID=B.TEAM_ID) ';
     //   die($sql);
        $result = $this->fetch($sql);
        return $result;
    }

    public function update($team){
	$sql='UPDATE TEAM SET FULL_NAME="'.$team['team_full_name'].'",'
                . 'SHORT_NAME="'.$team['team_short_name'].'" WHERE TEAM_ID="'.$team['team_id'].'" AND ACTIVE=1';
	$result=$this->query($sql);
        
        $sql="UPDATE ACCOUNT SET USER_EMAIL='".$team['team_email']."' WHERE ADMIN_TYPE='TEAM_ADMIN' AND TEAM_ID='".$team['team_id']."'";
	$result=$this->query($sql);
        
	return $result;
    }
    
    public function remove($team_id){
        $sql="UPDATE TEAM SET ACTIVE='0' WHERE TEAM_ID='$team_id' AND FULL_NAME!='Admin'";
	$result=$this->query($sql);	
        $account=new Account;
        $account->removeByAdmin('TEAM_ADMIN',$team_id);
        $member=new Member;
        $member->removeByTeam($team_id);
	return $result;
    }

}

?>
