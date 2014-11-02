<?php

class Team extends Model {

    public function add($team) {
        $sql = 'INSERT INTO TEAM (NAME) VALUES("' . $team['team_name'] . '")';
        $result = $this->query($sql);
        
        $account=new Account();
        $user=array(
            'username'=> $team['admin_username'],
            'password'=> $team['password'],
            'team_id'=>  $this->getInsertId(),
            'admin_type'=> 'TEAM_ADMIN'
        );
        $result_acc=$account->addUser($user);
        if($result_acc!==false){
          //  echo 'right '.json_encode($user);
        }else{
           // echo 'wrong '.json_encode($user);
        }
        return $result;
    }

    public function viewall() {
        $sql = 'SELECT * FROM( '
                . '(SELECT NAME,TEAM_ID AS T_ID FROM TEAM WHERE ACTIVE=1) A '
                . 'INNER JOIN'
                . '(SELECT * FROM ACCOUNT) B '
                . 'ON A.T_ID=B.TEAM_ID) ';
        $result = $this->fetch($sql);
        return $result;
    }

    public function view($team_id) {
        $sql = 'SELECT * FROM TEAM WHERE TEAM_ID="' . $team_id . '"';
        $result = $this->fetch($sql);
        return $result;
    }

    public function update($team){
	$sql='UPDATE TEAM SET NAME="'.$team['NAME'].'" WHERE TEAM_ID="'.$team['TEAM_ID'].'"';
	$result=$this->query($sql);	
	return $result;
    }
    
    public function remove($team_id){
        $sql="UPDATE TEAM SET ACTIVE='0' WHERE TEAM_ID='$team_id'";
	$result=$this->query($sql);	
        $account=new Account;
        $account=removeByAdmin('TEAM_ADMIN',$team_id);
	return $result;
    }

}

?>
