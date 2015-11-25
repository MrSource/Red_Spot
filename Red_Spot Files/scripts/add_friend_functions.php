<?php

/* 
 * Copyright 2015 Luis.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'config.php';
require 'PHPMailerAutoload.php';
include 'SpottersRelationShip.php';
include 'AccountClass.php';

//Check if the user set a function
if(isset($_POST['theFunction'])){
    $theFunction = $_POST['theFunction'];
    
    if($theFunction == "addFriend"){
        //Check if the user has set the relationship data
        if(isset($_POST['theData'])){
            $theData = json_decode($_POST['theData']);
            $spotterUsername = $theData->currentUser;
            $spotterRelated = $theData->userName;
            $role = $theData->role;
            
            //Create a relationship object
            $spottersRelationShipObject = new SpottersRelationShip();
            $spottersRelationShipObject->setSpotterUsername($spotterUsername);
            $spottersRelationShipObject->setSpotterRelated($spotterRelated);
            if(strcmp($role, "Establishment Owner") == 0){
                $spottersRelationShipObject->setRelation("User-Establishment");
            }
            else{
                 $spottersRelationShipObject->setRelation("");
            }
            
            
            $spottersRelationShipObject->insert($mysqli);
            //Create account object
            echo $spottersRelationShipObject->getRelation();
            if(!$spottersRelationShipObject->getRelation()){
                $accountObject = new AccountClass();
                $accountObject->setUsername($spotterRelated);
                $accountObject->getUserEmail($mysqli);
                $mail = $accountObject->getEmail();
                $customMail = new PHPMailer(); // create a new object
                $customMail->IsSMTP(); // enable SMTP
                $customMail->SMTPDebug = false; // debugging: 1 = errors and messages, 2 = messages only
                $customMail->do_debug = 0;
                $customMail->SMTPAuth = true; // authentication enabled
                $customMail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
                $customMail->Host = "smtp.gmail.com";
                $customMail->Port = 465; // or 587
                $customMail->IsHTML(true);
                $customMail->Username = "redspot.icom5016@gmail.com";
                $customMail->Password = "icom5016";
                $customMail->SetFrom("redspot.icom5016@gmail.com", "Red Spot");
                $customMail->Subject = "A spotter has added you on RedSpots";
                $customMail->Body = $spotterUsername . " has added you on RedSpots.";
                $customMail->AddAddress($mail);
                
                if (!$customMail->Send()) {
                    //echo "Mailer Error: " . $customMail->ErrorInfo;
                } else {
                    //echo "Message has been sent";
                }
                
            }
            
        }
    }
    
    if($theFunction == "removeFriend"){
        //Check if the user has set the relationship data
        if(isset($_POST['theData'])){
            $theData = json_decode($_POST['theData']);
            $spotterUsername = $theData->currentUser;
            $spotterRelated = $theData->userName;
            $role = $theData->role;
            
            //Create a relationship object
            $spottersRelationShipObject = new SpottersRelationShip();
            $spottersRelationShipObject->setSpotterUsername($spotterUsername);
            $spottersRelationShipObject->setSpotterRelated($spotterRelated);
            
            $spottersRelationShipObject->delete($mysqli);
        }
    }
}