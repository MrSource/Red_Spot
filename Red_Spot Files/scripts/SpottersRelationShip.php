<?php

/*
 * Copyright 2015 Programador.
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

/**
 * Description of SpottersRelationShip
 *
 * @author Programador
 */
class SpottersRelationShip {
    private $spotterUsername;
    private $spotterRelated;
    private $relation;
    
    function __construct() {
        
    }
    
    public function getSpotterUsername() {
        return $this->spotterUsername;
    }

    public function getSpotterRelated() {
        return $this->spotterRelated;
    }

    public function getRelation() {
        return $this->relation;
    }

    public function setSpotterUsername($spotterUsername) {
        $this->spotterUsername = $spotterUsername;
    }

    public function setSpotterRelated($spotterRelated) {
        $this->spotterRelated = $spotterRelated;
    }

    public function setRelation($relation) {
        $this->relation = $relation;
    }
    
     public function insert($mysqli) {
        //Query
        $query = "INSERT INTO spotters_relationship (`spotterUsername`, `spotterRelated`, `relation`) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("sss", $this->spotterUsername, $this->spotterRelated, $this->relation);
            $stmt->execute();
            $stmt->close();
        } else {
            echo $mysqli->error;
        }
        $mysqli->close();
        return;
    }
    
    public function delete($mysqli) {
        //Query
        $query = "DELETE FROM spotters_relationship WHERE `spotterUsername` = ? AND `spotterRelated` = ?";
        //Query2
        $query2 = "DELETE FROM spotters_relationship WHERE `spotterUsername` = ? AND `spotterRelated` = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $this->spotterUsername, $this->spotterRelated);
            $stmt->execute();
            $stmt->close();
        } else {
            echo $mysqli->error;
        }
        
        //Execute Query2
        if ($stmt2 = $mysqli->prepare($query2)) {
            $stmt2->bind_param("ss", $this->spotterRelated, $this->spotterUsername);
            $stmt2->execute();
            $stmt2->close();
        } else {
            echo $mysqli->error;
        }
        $mysqli->close();
        echo "Success";
    }

}
