<?php

class ProfilePicClass {

    private $userName;
    private $profilePicture;

    //Constructor
    function __construct() {
        
    }

    function getUserName() {
        return $this->userName;
    }

    function getProfilePicture() {
        return $this->profilePicture;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setProfilePicture($profilePicture) {
        $this->profilePicture = $profilePicture;
    }

    public function insert($mysqli) {
        //Query to set the profile picture URL
        $query = "INSERT INTO profile_pic (username, `profilePicture`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `profilePicture` = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("sss", $this->userName, $this->profilePicture, $this->profilePicture);
            $stmt->execute();
            $stmt->close();
            echo "Success";
        } else {
            echo $mysqli->error;
        }
    }
    
    public function extract($mysqli){
        //Query to get the profile picture URL
        $query = "SELECT profilePicture FROM profile_pic WHERE username = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("s", $this->userName);
            $stmt->execute();
            $stmt->bind_result($this->profilePicture);
            $stmt->fetch();
            $stmt->close();
            $theInformation = ["profilePicture"=>$this->profilePicture];
            echo json_encode($theInformation);
        } else {
            echo $mysqli->error;
        }
    }

}
