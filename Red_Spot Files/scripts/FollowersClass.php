<?php

class FollowersClass {

    private $userName;
    private $eventName;


    //Constructor
    function __construct() {
        
    }

    function getUserName() {
        return $this->userName;
    }

    function getEventName() {
        return $this->eventName;
}

    function setUserName() {
        $this->userName = $_SESSION['username'];
    }
    function setEventName($eventName) {
        $this->eventName = $eventName;
    }
    public function insert($mysqli) {
        //Variable to know whether we were successful running both queries
        $success = FALSE;
        //First query. Create the login information
        $query = "INSERT INTO followers (userName, eventName) VALUES (?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $this->userName, $this->eventName);
            $stmt->execute();
            $stmt->close();
            $success = TRUE;
        } else {
            echo $mysqli->error;
            $success = FALSE;
        }


    }
    }