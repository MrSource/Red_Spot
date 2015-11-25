<?php

class AccountClass {

    private $username;
    private $email;
    private $firstName;
    private $lastName;
    private $password;
    private $role;

    //Constructor
    function __construct() {
        
    }

    function getUsername() {
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }

    function getFirstName() {
        return $this->firstName;
    }

    function getLastName() {
        return $this->lastName;
    }

    function getPassword() {
        return $this->password;
    }

    function getRole() {
        return $this->role;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setRole($role) {
        $this->role = $role;
    }

    public function insert($mysqli) {
        //Variable to know whether we were successful running both queries
        $success = FALSE;
        //First query. Create the login information
        $query = "INSERT INTO login_user (username, email, password, `role`) VALUES (?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            //Let's hash the password
            $this->password = password_hash($this->password, PASSWORD_DEFAULT, ['cost' => 10]);
            $stmt->bind_param("ssss", $this->username, $this->email, $this->password, $this->role);
            $stmt->execute();
            $stmt->close();
            $success = TRUE;
        } else {
            echo $mysqli->error;
            $success = FALSE;
        }

        //Second query. Create the account information
        $query2 = "INSERT INTO accounts (username, email, `firstName`, `lastName`, `role`) VALUES (?, ?, ?, ?, ?)";
        if ($stmt2 = $mysqli->prepare($query2)) {
            $stmt2->bind_param("sssss", $this->username, $this->email, $this->firstName, $this->lastName, $this->role);
            $stmt2->execute();
            $stmt2->close();
            $success = TRUE;
            
        } else {
            echo $mysqli->error;
            $success = FALSE;
        }
        if($success){
            echo "Success";
            session_start();
            $_SESSION['Username'] = $this->username;
            $_SESSION['EmailAddress'] = $this->email;
            $_SESSION['LoggedIn'] = 1;
        }
    }
    
    public function verifyCredentials($mysqli) {
        //First query. Create the login information
        $query = "SELECT * FROM login_user WHERE `username` = ? OR `email` = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $this->username, $this->username);
            $stmt->execute();
            $stmt->bind_result($this->username, $this->email, $password, $this->role);
            $stmt->store_result();
            $stmt->fetch();
            if ($stmt->num_rows > 0) {
                // Change the cost of passwords being stored
                $options = ['cost' => 10];
                if (password_verify($this->password, $password)) {
                    // Check if the password needs to be rehashed
                    if (password_needs_rehash($password, PASSWORD_DEFAULT, $options)) {
                        // If so, create a new hash, and replace the old one
                        $newHash = password_hash($password, PASSWORD_DEFAULT, $options);
                    }
                    // Log user in
                    echo "OK";
                    session_start();
                    $_SESSION['Username'] = $this->username;
                    $_SESSION['Role'] = $this->role;
                    $_SESSION['EmailAddress'] = $this->email;
                    $_SESSION['LoggedIn'] = 1;
                }
            }
            $stmt->close();
        } else {
            echo $mysqli->error;
        }
    }
    
    public function getUserEmail($mysqli) {
        $query = "SELECT email FROM accounts WHERE `username` = ?";
        $mysqli = new mysqli("localhost", "redspot", "icom5016", "redspot");
        $stmt = $mysqli->prepare($query);
        if($stmt) {
            $stmt->bind_param("s", $this->username);
            $stmt->execute();
            $stmt->bind_result($this->email);
            $stmt->store_result();
            $stmt->fetch();
        }
        else {
            echo $mysqli->error;
        }
    
    }

}