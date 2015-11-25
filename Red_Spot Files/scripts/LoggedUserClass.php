<?php

class CheckInClass {

    private $userName;
    private $status;


    //Constructor
    function __construct() {
        
    }

    function getUserName() {
        return $this->userName;
    }

    function getStatus() {
        return $this->status;
}

    function setUserName() {
        $this->userName = $_SESSION['username'];
    }
    function setCategory($status) {
        $this->status = $status;
    }
    public function insert($mysqli) {
        //Variable to know whether we were successful running both queries
        $success = FALSE;
        //First query. Create the login information
        $query = "INSERT INTO logged_user (userName, status) VALUES (?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $this->userName, $this->status);
            $stmt->execute();
            $stmt->close();
            $success = TRUE;
        } else {
            echo $mysqli->error;
            $success = FALSE;
        }


    }
    }