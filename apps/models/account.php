<?php

class Account extends Model {

    public function __construct() {

        parent::__construct();
        $sql = "SELECT * FROM TEAM WHERE NAME='ADMIN'";

        $result = $this->fetch($sql);

        if ($result !== false && !empty($result)) {
            
        } else {
            $sql = "INSERT INTO TEAM (NAME,ADMIN_ID) VALUES('ADMIN','1')";
            $result_team = $this->query($sql);

            $sql = "INSERT INTO ACCOUNT (USERNAME,PASSWORD,ADMIN_TYPE,TEAM_ID)
                    VALUES ('shift_admin','" . MD5('admin@12345') . "','APP_ADMIN','1')";
            $result_admin = $this->query($sql);
        }
    }

    public function login($user) {
        $sql = "SELECT * FROM ("
                . " (SELECT * FROM ACCOUNT WHERE USERNAME='" . $user['username'] . "' AND PASSWORD='" . $user['password'] . "' LIMIT 1) A"
                . " LEFT JOIN"
                . " (SELECT TEAM_ID AS T_ID,NAME FROM TEAM) B"
                . " ON A.TEAM_ID=B.T_ID)";
        $result = $this->fetch($sql);

        if ($result !== false) {

            foreach ($result as $account) {
                $_SESSION['USER_ID'] = $account['USER_ID'];
                $_SESSION['ADMIN_TYPE'] = $account['ADMIN_TYPE'];
                $_SESSION['TEAM_ID'] = $account['TEAM_ID'];
                $_SESSION['USER_NAME'] = $account['USERNAME'];
                $_SESSION['TEAM_NAME'] = $account['NAME'];
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
        $sql = 'INSERT INTO ACCOUNT (USERNAME,PASSWORD,ADMIN_TYPE,TEAM_ID) '
                . 'VALUES("' . $user["username"] . '","' . $user["password"] . '",'
                . '"' . $user["admin_type"] . '","' . $user["team_id"] . '")';
        $result = $this->query($sql);
        return $result;
    }

    public function removeByAdmin($admin_type, $team_id) {
        $sql = "DELETE FROM ACCOUNT WHERE TEAM_ID='$team_id' AND ADMIN_TYPE='$admin_type'";
        $result = $this->query($sql);
        return $result;
    }

}
