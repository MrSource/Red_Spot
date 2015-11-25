<?php

class EventClass {

    private $userName;
    private $eventName;
    private $eventInformation;
    private $date;
    private $hour;
    private $place;

    //Constructor
    function __construct() {
        
    }

    function getUsername() {
        return $this->userName;
    }

    function getEventName() {
        return $this->eventName;
    }

    function getEventInformation() {
        return $this->eventInformation;
    }

    function getDate() {
        return $this->date;
    }

    function getHour() {
        return $this->hour;
    }

    function getPlace() {
        return $this->place;
    }

    function setUsername() {
        $this->userName = $_SESSION['username'];
    }

    function setEventName($eventName) {
        $this->eventName = $eventName;
    }

    function setEventInformation($eventInformation) {
        $this->eventInformation = $eventInformation;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setHour($hour) {
        $this->hour = $hour;
    }

    function setPlace($place) {
        $this->place = $place;
    }

    public function insert($mysqli) {
        //Variable to know whether we were successful running both queries
        $success = FALSE;
        //First query. Create the login information
        $query = "INSERT INTO event (username, eventName, date, hour, place) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("sssss", $this->userName, $this->eventName, $this->date, $this->hour, $this->place);
            $stmt->execute();
            $stmt->close();
            $success = TRUE;
        } else {
            echo $mysqli->error;
            $success = FALSE;
        }

    }

    public function verifyCredentials($mysqli) {

    }

}
