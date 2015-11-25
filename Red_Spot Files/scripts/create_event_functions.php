<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'config.php';

//Check if our function is set
if (isset($_POST['theFunction'])) {
    $theFunction = $_POST['theFunction'];
    if ($theFunction == "extractEventData")
        if (isset($_POST['eventData'])){
            //Insert new event to the event details table
            $query = "INSERT INTO event_details (userName,userInvited,eventName,eventInformation,dateAndTime,place) VALUES (?,?,?,?,?,?)";
            $eventData = json_decode($_POST['eventData']);
            $currentUser = $eventData->currentUser;
            $userInvited = $eventData->userInvited;
            $eventName = $eventData->eventName;
            $eventInformation = $eventData->eventInformation;
            $date = $eventData->date;
            $spot = $eventData->spot;

            if ($stmt = $mysqli->prepare($query)) {
               for($i=0; $i<count($userInvited);$i++){ 
                $stmt->bind_param("ssssss", $currentUser, $userInvited[$i], $eventName, $eventInformation, $date, $spot);
                $stmt->execute();
               }
                $stmt->close();
                echo('event inserted');
            } else {
                echo $mysqli->error;
            }
        }
}

        