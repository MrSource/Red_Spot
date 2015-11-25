<?php

class FriendRequestClass {

    private $ID;
    private $userNameRequest;
    private $userNameRequested;
    private $status;


    //Constructor
    function __construct() {
        
    }

    function getID() {
        return $this->ID;
    }

    function getUserNameRequest() {
        return $this->userNameRequest;
    }

    function getUserNameRequested() {
        return $this->userNameRequested;
    }

    function getStatus() {
        return $this->status;
    }

   

    function setID($ID) {
        $this->ID = $ID;
    }

    function setUserNameRequest($userNameRequest) {
        $this->userNameRequest = $userNameRequest;
    }

    function setUserNameRequested() {
        $this->userNameRequested = $_SESSION['username'];
    }

    function setStatus($status) {
        $this->status = $status;
    }

    
    public function insert($mysqli) {
        //Variable to know whether we were successful running both queries
        $success = FALSE;
        //First query. Create the login information
        $query = "INSERT INTO friend_request (ID, userNAmeRequest, userNameRequested, status) VALUES (?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ssss", $this->ID, $this->userNameRequest, $this->userNameRequested, $this->status);
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