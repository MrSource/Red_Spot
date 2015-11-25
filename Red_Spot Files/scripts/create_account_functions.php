<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once 'config.php';
include 'AccountClass.php';

//Check if our function is set
if(isset($_POST['theFunction'])){
	$theFunction = $_POST['theFunction'];
        
        //Check if we are asked to insert
	if($theFunction == "insertData"){
            //Check if we have been given the neccessary data
            if(isset($_POST['theData'])){
                $theData = json_decode($_POST['theData']);
                $firstName = $theData->firstName;
                $lastName = $theData->lastName;
                $username = $theData->username;
                $email = $theData->email;
                $password = $theData->password;
                $role = $theData->role;
                
                //Create the account object
                $accountObject = new AccountClass();
                
                $accountObject->setUsername($username);
                $accountObject->setEmail($email);
                $accountObject->setFirstName($firstName);
                $accountObject->setLastName($lastName);
                $accountObject->setPassword($password);
                $accountObject->setRole($role);
                
                $accountObject->insert($mysqli);
            }
        }
        
        //Check if we are asked to extract a list of usernames
	if($theFunction == "validateUsername"){
            //Check if we have been given the neccessary data
            if(isset($_POST['theData'])){
                $theData = json_decode($_POST['theData']);
                $username = $theData->username;
                $query = "SELECT username FROM accounts";
                if ($stmt = $mysqli->prepare($query)){
                        $stmt->execute();
                        $stmt->bind_result($username2);
                        $usernameExists = 0;
                        while($stmt->fetch()){
                            if(strcmp($username, $username2) == 0){
                                $usernameExists = 1;
                            }
                        }
                        $stmt->close();
                        $mysqli->close();
                        echo $usernameExists;
                }
                else{
                    echo $mysqli->error;
                }
            }
        }
        
        //Check if we are asked to extract a list of emails
	if($theFunction == "validateEmail"){
            //Check if we have been given the neccessary data
            if(isset($_POST['theData'])){
                $theData = json_decode($_POST['theData']);
                $email = $theData->email;
                $query = "SELECT email FROM accounts";
                if ($stmt = $mysqli->prepare($query)){
                        $stmt->execute();
                        $stmt->bind_result($email2);
                        $emailExists = 0;
                        while($stmt->fetch()){
                            if(strcmp($email, $email2) == 0){
                                $emailExists = 1;
                            }
                        }
                        $stmt->close();
                        $mysqli->close();
                        echo $emailExists;
                }
                else{
                    echo $mysqli->error;
                }
            }
        }
}