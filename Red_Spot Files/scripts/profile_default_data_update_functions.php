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
include 'ProfilePicClass.php';

if (isset($_POST['theFunction'])) {
    $theFunction = $_POST['theFunction'];

    //Check if we are asked to insert
    if ($theFunction == "profilePictureUpload") {
        if (isset($_POST['theData'])) {
            //First table update
            $theData = json_decode($_POST['theData']);
            $username = $theData->username;
            $profilePicture = $theData->profilePicture;
            
            $profilePicObject = new ProfilePicClass();
            $profilePicObject->setUserName($username);
            $profilePicObject->setProfilePicture($profilePicture);
            $profilePicObject->insert($mysqli);
        }
    }
    
    //Check if we are asked to extract
    if ($theFunction == "getProfilePicture") {
        if (isset($_POST['theData'])) {
            //First table update
            $theData = json_decode($_POST['theData']);
            $username = $theData->username;
            
            $profilePicObject = new ProfilePicClass();
            $profilePicObject->setUserName($username);
            $profilePicObject->extract($mysqli);
        }
    }
}