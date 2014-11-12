<?php

class Account extends Model {

    public function __construct() {

        parent::__construct();
        $sql = "SELECT * FROM( "
                . " (SELECT TEAM_ID AS T_ID FROM TEAM WHERE FULL_NAME='ADMIN') A"
                . " INNER JOIN"
                . " (SELECT TEAM_ID FROM ACCOUNT WHERE ADMIN_TYPE='APP_ADMIN') B"
                . " ON A.T_ID=B.TEAM_ID)";
      //  die($sql);
        $result = $this->fetch($sql);

        if ($result !== false && !empty($result)) {
            
        } else {
            $sql = "INSERT INTO TEAM (FULL_NAME,SHORT_NAME) VALUES('ADMIN','ADMIN')";
            $result_team = $this->query($sql);           

            $user = array(
                'username' => 'shift_admin',
                'password' => MD5('admin@12345'),
                'team_id' => $this->getInsertId(),
                'admin_type' => 'APP_ADMIN',
                'user_email' => ADMIN_EMAIL
            );
            $result_admin = $this->addUser($user);
        }
    }

    public function login($user) {
        $sql = "SELECT * FROM ("
                . " (SELECT * FROM ACCOUNT WHERE USERNAME='" . $user['username'] . "' AND PASSWORD='" . $user['password'] . "' LIMIT 1) A"
                . " LEFT JOIN"
                . " (SELECT TEAM_ID AS T_ID,FULL_NAME,SHORT_NAME FROM TEAM) B"
                . " ON A.TEAM_ID=B.T_ID)";
        $result = $this->fetch($sql);

        if ($result !== false) {

            foreach ($result as $account) {
                $_SESSION['USER_ID'] = $account['USER_ID'];
                $_SESSION['ADMIN_TYPE'] = $account['ADMIN_TYPE'];
                $_SESSION['TEAM_ID'] = $account['TEAM_ID'];
                $_SESSION['USER_NAME'] = $account['USERNAME'];
                $_SESSION['TEAM_NAME'] = $account['FULL_NAME'];
                $_SESSION['TEAM_SHORT_NAME'] = $account['SHORT_NAME'];
                $_SESSION['PASSWORD_TYPE'] = $account['PASSWORD_TYPE'];
                $_SESSION['MEMBER_ID'] = $account['MEMBER_ID'];
                return true;
            }
        }
        return false;
    }

    public function check_user() {

        if (isset($_SESSION['USER_ID']) && !empty($_SESSION['USER_ID'])) {
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        unset($_SESSION['USER_ID']);
        unset($_SESSION['ADMIN_TYPE']);
        unset($_SESSION['TEAM_ID']);
        unset($_SESSION['USER_NAME']);
        unset($_SESSION['TEAM_NAME']);
        unset($_SESSION['TEAM_SHORT_NAME']);
        unset($_SESSION['PASSWORD_TYPE']);
        return true;
    }

    public function check_username($username) {
        $sql = "SELECT COUNT(USER_ID) AS NO FROM ACCOUNT WHERE USERNAME='$username'";
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

    public function addUser($user) {
        
        if(!isset($user["member_id"]) || empty($user["member_id"]) ){
            $user["member_id"]=-1;
        }
        
        $sql = 'INSERT INTO ACCOUNT (USERNAME,PASSWORD,ADMIN_TYPE,USER_EMAIL,TEAM_ID,MEMBER_ID) '
                . 'VALUES("' . $user["username"] . '","' . $user["password"] . '",'
                . '"' . $user["admin_type"] . '","' . $user["user_email"] . '","' . $user["team_id"] . '","' . $user["member_id"] . '")';
        $result = $this->query($sql);
        return $result;
    }

    public function removeByAdmin($admin_type, $team_id) {
        $sql = "DELETE FROM ACCOUNT WHERE TEAM_ID='$team_id' AND ADMIN_TYPE='$admin_type'";
        $result = $this->query($sql);
        return $result;
    }

    public function reset_password($user){
        $sql="UPDATE ACCOUNT SET PASSWORD='".md5($user['password'])."',PASSWORD_TYPE='FULL_TIME' WHERE USER_ID='".$user['user_id']."'";
        $result = $this->query($sql);
        return $result;
    }

    public function forget_password($user){
        $sql="UPDATE ACCOUNT SET PASSWORD='".md5($user['password'])."',PASSWORD_TYPE='PART_TIME' WHERE USER_ID='".$user['USER_ID']."'";
        $result = $this->query($sql);
        return $result;
    }
    
    public function readUser($username){
        $sql="SELECT * FROM ACCOUNT WHERE USERNAME='$username'";
      
        $result = $this->fetch($sql);
        return $result;
    }
}
