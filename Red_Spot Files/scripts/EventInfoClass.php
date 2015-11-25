<?php

class EventInfoClass {

    private $userName;
    private $host;
    private $read;


    //Constructor
    function __construct() {
        
    }

    function getUserName() {
        return $this->userName;
    }

    function getHost() {
        return $this->host;
    }

    function getRead() {
        return $this->read;
    }



   
    function setUserName() {
        $this->userName = $_SESSION['username'];
    }

    function setHost($host) {
        $this->host = $host;
    }

    function setRead($read) {
        $this->read = $read;
    }


    
    public function insert($mysqli) {
        //Variable to know whether we were successful running both queries
        $success = FALSE;
        //First query. Create the login information
        $query = "INSERT INTO event_info (userName, host, read) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("sss", $this->userName, $this->host, $this->read, $this->longitude);
            $stmt->execute();
            $stmt->close();
            $success = TRUE;
        } else {
            echo $mysqli->error;
            $success = FALSE;
        }


    }

    public function verifyCredentials($mysqli) {
  

}
}