<?php

/*
 * Copyright 2015 Red Spot.
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
include 'AccountClass.php';

//Check if our function is set
if (isset($_POST['theFunction'])) {
    $theFunction = $_POST['theFunction'];

    //Check if we are asked to insert
    if ($theFunction == "changeUserDataNoPassword") {
        if (isset($_POST['theData'])) {
            //First table update
            $query = "UPDATE login_user SET email = ? WHERE username = ?";
            $theData = json_decode($_POST['theData']);
            $username = $theData->username;
            $email = $theData->email;
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("ss", $email, $username);
                $stmt->execute();
                $stmt->close();
            } else {
                echo $mysqli->error;
            }
            //Second table update
            $query = "UPDATE accounts SET email = ?, `firstName` = ?, `lastName` = ? WHERE username = ?";
            $theData = json_decode($_POST['theData']);
            $firstName = $theData->firstName;
            $lastName = $theData->lastName;
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("ssss", $email, $firstName, $lastName, $username);
                $stmt->execute();
                $stmt->close();
                $mysqli->close();
                echo "Success";
            } else {
                echo $mysqli->error;
            }
        }
    }

    //Check if we are asked to insert
    if ($theFunction == "changeUserData") {
        if (isset($_POST['theData'])) {
            //First table update
            $query = "UPDATE login_user SET email = ? WHERE username = ?";
            $theData = json_decode($_POST['theData']);
            $username = $theData->username;
            $email = $theData->email;
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("ss", $email, $username);
                $stmt->execute();
                $stmt->close();
            } else {
                echo $mysqli->error;
            }
            //Second table update
            $query = "UPDATE accounts SET email = ?, `firstName` = ?, `lastName` = ? WHERE username = ?";
            $theData = json_decode($_POST['theData']);
            $firstName = $theData->firstName;
            $lastName = $theData->lastName;
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("ssss", $email, $firstName, $lastName, $username);
                $stmt->execute();
                $stmt->close();
            } else {
                echo $mysqli->error;
            }
            
            //Change password query
            $query = "SELECT password FROM login_user WHERE username = ?";
            $query2 = "UPDATE login_user SET password = ? WHERE username = ?";
            $theData = json_decode($_POST['theData']);
            $oldPassword = $theData->oldPassword;
            $newPassword = $theData->newPassword;
            $oldPassHash;
            $newPasswordHash;
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->bind_result($oldPassHash);
                $stmt->fetch();
                $stmt->close();
            } else {
                echo $mysqli->error;
            }
            if (password_verify($oldPassword, $oldPassHash)) {
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT, ['cost' => 10]);
                if ($stmt2 = $mysqli->prepare($query2)) {
                    $stmt2->bind_param("ss", $newPasswordHash, $username);
                    $stmt2->execute();
                    $stmt2->close();
                    $mysqli->close();
                    echo "Success";
                } else {
                    echo $mysqli->error;
                }
            } else {
                echo "Wrong password";
            }
        }
    }

    //Check if we are asked to insert
    if ($theFunction == "extractUserData") {
        if (isset($_POST['theData'])) {
            $query = "SELECT * FROM accounts WHERE username = ?";
            $theData = json_decode($_POST['theData']);
            $username = $theData->username;

            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->bind_result($username2, $email, $firstName, $lastName, $role);
                $stmt->fetch();
                $theInformation = ["firstName" => $firstName, "lastName" => $lastName, "email" => $email];
                $stmt->close();
                $mysqli->close();
                echo json_encode($theInformation);
            } else {
                echo $mysqli->error;
            }
        }
    }
}
