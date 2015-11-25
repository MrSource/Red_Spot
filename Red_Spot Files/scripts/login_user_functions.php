<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once 'config.php';
include 'AccountClass.php';

//Check if our function is set
if(isset($_POST['theFunction'])){
	$theFunction = $_POST['theFunction'];
        
        //Check if we are asked to extract the user
	if($theFunction == "login"){
            //Check if we have been given the neccessary data
            if(isset($_POST['theData'])){
                $theData = json_decode($_POST['theData']);
                $username = $theData->username;
                $password = $theData->password;
                
                //Create the account object
                $accountObject = new AccountClass();
                
                $accountObject->setUsername($username);
                $accountObject->setPassword($password);
                
                $accountObject->verifyCredentials($mysqli);
            }
        }
        
        //Check for usernames or emails for validity on the login form
	if($theFunction == "validateLoginUsername"){
            //Check if we have been given the neccessary data
            if(isset($_POST['theData'])){
                $theData = json_decode($_POST['theData']);
                $username = $theData->username;
                $query = "SELECT * FROM accounts";
                if ($stmt = $mysqli->prepare($query)){
                        $stmt->execute();
                        $stmt->bind_result($username2, $email, $firstName, $lastName, $role);
                        $usernameExists = 0;
                        while($stmt->fetch()){
                            if(strcmp($username, $username2) == 0 || strcmp($username, $email) == 0){
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
}