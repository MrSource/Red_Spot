<?php

class ReportClass {

    private $userName;
    private $bio;
    private $gender;
    private $dateOfBirth;


    //Constructor
    function __construct() {
        
    }

    function getUserName() {
        return $this->userName;
    }

    function getBio() {
        return $this->bio;
    }

    function getGender() {
        return $this->gender;
    }

    function getDateOfBirth() {
        return $this->dateOfBirth;
    }

   

    function setUserName() {
        $this->userName = $_SESSION['establishmentName'];
    }

    function setBio($bio) {
        $this->bio =$bio;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setDateOfBirth($dateOfBirth) {
        $this->dateOfBirth = $dateOfBirth;
    }

    
    public function insert($mysqli) {
        //Variable to know whether we were successful running both queries
        $success = FALSE;
        //First query. Create the login information
        $query = "INSERT INTO report (userName, bio, gender, dateOfBirth) VALUES (?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ssss", $this->userName, $this->bio, $this->gender, $this->dateOfBirth);
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