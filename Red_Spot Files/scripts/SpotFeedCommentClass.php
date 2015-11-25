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

class SpotFeedCommentClass {

    private $username;
    private $comment;
    private $establishmentName;

    public function __construct() {
        
    }

    public function getUsername() {
        return $this->username;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getEstablishmentName() {
        return $this->establishmentName;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function setEstablishmentName($establishmentName) {
        $this->establishmentName = $establishmentName;
    }

    public function insert($mysqli) {
        $query = "INSERT INTO spot_feed_comments (`username`, `comment`, `establishmentName`) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("sss", $this->username, $this->comment, $this->establishmentName);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function extract($mysqli) {
        $query = "SELECT * FROM spot_feed_comments WHERE `username` = ? AND `establishmentName` = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $this->username, $this->establishmentName);
            $stmt->execute();
            $stmt->bind_result($this->username, $this->comment, $this->establishmentName);
            $stmt->fetch();
            $theData = array("username" => $this->username,
                "comment" => $this->comment,
                "establishmentName" => $this->establishmentName);
            echo json_encode($theData);
            $stmt->close();
        }
    }

    public function delete($mysqli) {
        $query = "DELETE FROM spot_feed_comments WHERE `username` = ? AND `establishmentName` = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $this->username, $this->establishmentName);
            $stmt->execute();
            $stmt->close();
        }
    }
}