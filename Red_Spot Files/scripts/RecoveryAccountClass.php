<?php

class RecoveryAccountClass {

    private $userName;
    private $securityQuestion;
    private $securityAnswer;
    private $active;


    //Constructor
    function __construct() {
        
    }

    function getUserName() {
        return $this->userName;
    }

    function getSecurityQuestion() {
        return $this->securityQuestion;
    }

    function getSecurityAnswer() {
        return $this->securityAnswer;
    }

    function getActive() {
        return $this->active;
    }

   

    function setUserName() {
        $this->userName = $_SESSION['userName'];
    }

    function setSecurityQuestion($securityQuestion) {
        $this->securityQuestion = $securityQuestion;
    }

    function setSecurityAnswer($securityAnswer) {
        $this->securityAnswer = $securityAnswer;
    }

    function setActive($active) {
        $this->active = $active;
    }

    
    public function insert($mysqli) {
        //Variable to know whether we were successful running both queries
        $success = FALSE;
        //First query. Create the login information
        $query = "INSERT INTO recovery_account_info (userName, securityQuestion, securityAnswer, active) VALUES (?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ssss", $this->userName, $this->securityQuestion, $this->securityAnswer, $this->active);
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