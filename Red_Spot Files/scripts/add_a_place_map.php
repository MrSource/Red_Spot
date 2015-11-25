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
include 'EstablishmentLocationClass.php';
include 'EstablishmentGalleryClass.php';
//Check if our function is set
if (isset($_POST['theFunction'])) {
    $theFunction = $_POST['theFunction'];

    //Check if we are asked to add an establishment
    if ($theFunction == "addEstablishmentLocation") {
        if (isset($_POST['theData'])) {
            $theData = json_decode($_POST['theData']);
            $username = $theData->username;
            $establishmentName = $theData->establishmentName;
            $latitude = $theData->latitude;
            $longitude = $theData->longitude;
            $review = $theData->review;
            $scale = $theData->scale;

            $EstablishmentLocationClassObject = new EstablishmentLocationClass();
            $EstablishmentLocationClassObject->setUsername($username);
            $EstablishmentLocationClassObject->setEstablishmentName($establishmentName);
            $EstablishmentLocationClassObject->setLatitude($latitude);
            $EstablishmentLocationClassObject->setLongitude($longitude);
            $EstablishmentLocationClassObject->setReview($review);
            $EstablishmentLocationClassObject->setScale($scale);
            $EstablishmentLocationClassObject->insert($mysqli);
        }
    }
    
    //Check if we are asked to add an establishment with a picture
    if ($theFunction == "addEstablishmentLocationWithPicture") {
        if (isset($_POST['theData'])) {
            $theData = json_decode($_POST['theData']);
            $username = $theData->username;
            $establishmentName = $theData->establishmentName;
            $establishmentName = $theData->establishmentName;
            $latitude = $theData->latitude;
            $longitude = $theData->longitude;
            $review = $theData->review;
            $scale = $theData->scale;
            $photo = $theData->photo;

            //Add the estabishment location
            $EstablishmentLocationClassObject = new EstablishmentLocationClass();
            $EstablishmentLocationClassObject->setUsername($username);
            $EstablishmentLocationClassObject->setEstablishmentName($establishmentName);
            $EstablishmentLocationClassObject->setLatitude($latitude);
            $EstablishmentLocationClassObject->setLongitude($longitude);
            $EstablishmentLocationClassObject->setReview($review);
            $EstablishmentLocationClassObject->setScale($scale);
            $EstablishmentLocationClassObject->insert($mysqli);
            
            //Add the establishment picture
            $EstablishmentGalleryClassObject = new EstablishmentGalleryClass();
            $EstablishmentGalleryClassObject->setUsername($username);
            $EstablishmentGalleryClassObject->setEstablishmentName($establishmentName);
            $EstablishmentGalleryClassObject->setPhoto($photo);
            $EstablishmentGalleryClassObject->insert($mysqli);
        }
    }
}