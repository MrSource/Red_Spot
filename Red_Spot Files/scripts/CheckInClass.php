<?php

class CheckInClass {

    private $userName;
    private $checkInLocation;


    //Constructor
    function __construct() {
        
    }

    function getUserName() {
        return $this->userName;
    }

    function getCheckInLocation() {
        return $this->checkInLocation;
}

    function setUserName() {
        $this->userName = $_SESSION['username'];
    }
    function setCategory($checkInLocation) {
        $this->checkInLocation = $checkInLocation;
    }
    public function insert($mysqli) {
        //Variable to know whether we were successful running both queries
        $success = FALSE;
        //First query. Create the login information
        $query = "INSERT INTO check_in_location (userName, checkInLocation) VALUES (?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $this->userName, $this->checkInLocation);
            $stmt->execute();
            $stmt->close();
            $success = TRUE;
        } else {
            echo $mysqli->error;
            $success = FALSE;
        }


    }
    }