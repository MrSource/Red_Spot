<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'config.php';
include 'EstablishmentInfoClass.php';

//Check if our function is set
if (isset($_POST['theFunction'])) {
    $theFunction = $_POST['theFunction'];

    //Check if we are asked to add an establishment
    if ($theFunction == "addEstablishment") {
        if (isset($_POST['theData'])) {
            $theData = json_decode($_POST['theData']);
            $username = $theData->username;
            $establishmentName = $theData->establishmentName;
            $schedule = $theData->schedule;
            $parking = $theData->parking;
            $information = $theData->information;
            $telephone = $theData->telephone;
            $category = $theData->category;
            $latitude = $theData->latitude;
            $longitude = $theData->longitude;
            $photo = $theData->photo;
            $EstablishmentInfoClassObject = new EstablishmentInfoClass();
            $EstablishmentInfoClassObject->setUsername($username);
            $EstablishmentInfoClassObject->setEstablishmentName($establishmentName);
            $EstablishmentInfoClassObject->setSchedule($schedule);
            $EstablishmentInfoClassObject->setParking($parking);
            $EstablishmentInfoClassObject->setInformation($information);
            $EstablishmentInfoClassObject->setTelephone($telephone);
            $EstablishmentInfoClassObject->setCategory($category);
            $EstablishmentInfoClassObject->setLatitude($latitude);
            $EstablishmentInfoClassObject->setLongitude($longitude);
            $EstablishmentInfoClassObject->setPhoto($photo);
            $EstablishmentInfoClassObject->insert($mysqli);
        }
    }
    //Check if we are asked to add an establishment
    if ($theFunction == "extractEstablishment") {
        if (isset($_POST['theData'])) {
            $theData = json_decode($_POST['theData']);
            $username = $theData->username;
            $establishmentName = $theData->establishmentName;
            $EstablishmentInfoClassObject = new EstablishmentInformationClass();
            $EstablishmentInfoClassObject->setUsername($username);
            $EstablishmentInfoClassObject->setEstablishmentName($establishmentName);
            $EstablishmentInfoClassObject->extract($mysqli);
        }
    }
}