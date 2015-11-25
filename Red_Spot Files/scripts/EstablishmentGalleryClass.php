<?php

class EstablishmentGalleryClass {
    
    private $username;
    private $establishmentName;
    private $photo;


    //Constructor
    function __construct() {
        
    }

    function getEstablishmentName() {
        return $this->establishmentName;
    }

    function getPhoto() {
        return $this->photo;
}

    function setEstablishmentName($establishmentName) {
        $this->establishmentName = $establishmentName;
    }
    function setPhoto($photo) {
        $this->photo = $photo;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

        public function insert($mysqli) {
        //Query to insert the data into the establishment gallery
        $query = "INSERT INTO establishment_gallery (username, establishmentName, photo) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("sss", $this->username, $this->establishmentName, $this->photo);
            $stmt->execute();
            $stmt->close();
            echo "Success";
        } else {
            echo $mysqli->error;
        }


    }
    }