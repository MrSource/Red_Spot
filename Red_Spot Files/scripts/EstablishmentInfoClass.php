<?php

class EstablishmentInfoClass {

    private $username;
    private $establishmentName;
    private $schedule;
    private $parking;
    private $information;
    private $telephone;
    private $category;
    private $latitude;
    private $longitude;
    private $photo;

    public function __construct() {
        
    }

    function getUsername() {
        return $this->username;
    }

    public function getEstablishmentName() {
        return $this->establishmentName;
    }

    public function getSchedule() {
        return $this->schedule;
    }

    public function getParking() {
        return $this->parking;
    }

    public function getInformation() {
        return $this->information;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    function getPhoto() {
        return $this->photo;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    public function setEstablishmentName($establishmentName) {
        $this->establishmentName = $establishmentName;
    }

    public function setSchedule($schedule) {
        $this->schedule = $schedule;
    }

    public function setParking($parking) {
        $this->parking = $parking;
    }

    public function setInformation($information) {
        $this->information = $information;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function insert($mysqli) {
        $query = "INSERT INTO establishment_information (username, `establishmentName`, `schedule`, `parking`, `information`, `telephone`, `category`, `latitude`, `longitude`, `photo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            echo "within stmt";
            $stmt->bind_param("sssisssdds", $this->username, $this->establishmentName, $this->schedule, $this->parking, $this->information, $this->telephone, $this->category, $this->latitude, $this->longitude, $this->photo);
            $stmt->execute();
            $stmt->close();
            echo "Success";
        } else {
            echo $mysqli->error;
        }
    }

    public function extract($mysqli) {
        $query = "SELECT * FROM establishment_information WHERE username = ? AND `establishmentName` = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $this->username, $this->establishmentName);
            $stmt->execute();
            $stmt->bind_result($this->username, $this->establishmentName, $this->schedule, $this->parking, $this->information, $this->telephone, $this->category, $this->latitude, $this->longitude, $this->photo);
            $stmt->fetch();
            $theData = array("username" => $this->username, "establishmentName" => $this->establishmentName,
                "schedule" => $this->schedule,
                "parking" => $this->parking,
                "information" => $this->information,
                "telephone" => $this->telephone,
                "category" => $this->category,
                "latitude" => $this->latitude,
                "longitude" => $this->longitude,
                "photo" => $this->photo);
            echo json_encode($theData);
            $stmt->close();
        }
    }

    public function delete($mysqli) {
        $query = "DELETE FROM establishment_information WHERE username = ? AND `establishmentName` = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $this->username, $this->establishmentName);
            $stmt->execute();
            $stmt->close();
        }
    }
}
