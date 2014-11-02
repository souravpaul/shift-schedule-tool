<?php

class SQLQuery {

    protected $_dbHandle;
    protected $_result;

    /** Connects to database * */
    function connect($address, $account, $pwd, $name) {
        $this->_dbHandle = @mysqli_connect($address, $account, $pwd);
        if ($this->_dbHandle) {
            if (mysqli_select_db($this->_dbHandle, $name)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /** Disconnects from database * */
    function disconnect() {
        if (@mysqli_close($this->_dbHandle) != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function query($sql) {
        $result = mysqli_query($this->_dbHandle, $sql);
        $this->_result=$result;
        return $result;
    }

    public function fetch($sql) {
        $result_set = array();
        $result = mysqli_query($this->_dbHandle, $sql);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($result_set,$row);
            }
            mysqli_free_result($result);
            return $result_set;
        }
        return false;
    }

    function getInsertId(){
        return mysqli_insert_id($this->_dbHandle);        
    }


    /** Get number of rows * */
    function getNumRows() {
        return mysql_num_rows($this->_result);
    }

    /** Free resources allocated by a query * */
    function freeResult() {
        mysql_free_result($this->_result);
    }

    /** Get error string * */
    function getError() {
        return mysqlI_error($this->_dbHandle);
    }

}

?>
