<?php

class EstablishmentLocationClass {

    private $userName;
    private $establishmentName;
    private $latitude;
    private $longitude;
    private $review;
    private $scale;

    //Constructor
    function __construct() {
        
    }

    function getUserName() {
        return $this->userName;
    }

    function getEstablishmentName() {
        return $this->establishmentName;
    }

    function getLangitude() {
        return $this->latitude;
    }

    function getLongitude() {
        return $this->longitude;
    }

   

    function setUserName($username) {
        $this->userName = $username;
    }

    function setEstablishmentName($establishmentName) {
        $this->establishmentName = $establishmentName;
    }

    function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    function setLongitude($longitude) {
        $this->longitude = $longitude;
    }
    
    public function getReview() {
        return $this->review;
    }

    public function getScale() {
        return $this->scale;
    }

    public function setReview($review) {
        $this->review = $review;
    }

    public function setScale($scale) {
        $this->scale = $scale;
    }

    
    
    public function insert($mysqli) {
        //First query. Create the login information
        $query = "INSERT INTO establishment_location (userName, establishmentName, latitude, longitude, review, scale) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ssddsi", $this->userName, $this->establishmentName, $this->latitude, $this->longitude, $this->review, $this->scale);
            $stmt->execute();
            $stmt->close();
            echo "Success";
        } else {
            echo $mysqli->error;
        }
    }
}