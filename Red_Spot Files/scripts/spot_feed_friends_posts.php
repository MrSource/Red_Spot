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

if (isset($_POST['theFunction'])) {
    $theFunction = $_POST['theFunction'];

    //Check if we are asked to insert
    if ($theFunction == "getSpotFeed") {
        if (isset($_POST['theData'])) {
            //First table update
            $theData = json_decode($_POST['theData']);
            $username = $theData->username;
            $user_arr = array();
            //Query to check for relationship
            $query = "SELECT `spotterUsername`, `spotterRelated` FROM spotters_relationship WHERE (`spotterUsername` = ? OR `spotterRelated` = ?)";
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("ss", $username, $username);
                $stmt->execute();
                $stmt->bind_result($spotterUsername, $spotterRelated);
                while ($stmt->fetch()) {
                    //Put the results into an array
                    if ($spotterUsername != $username) {
                        $user_arr[] = ["spotterRelated" => $spotterUsername];
                    }
                    if ($spotterRelated != $username) {
                        $user_arr[] = ["spotterRelated" => $spotterRelated];
                    }
                }
                //Close the prepared statement
                $stmt->close();
            }
            //Query to extract the data from the table establishment_location
            $query2 = "SELECT * FROM establishment_location WHERE username = ?";
            $establishmentLocationArray = array();
            if ($stmt2 = $mysqli->prepare($query2)) {
                foreach ($user_arr as $key => $value) {
                    $stmt2->bind_param("s", $value['spotterRelated']);
                    $stmt2->execute();
                    $stmt2->bind_result($username1, $establishmentName, $latitude, $longitude, $review, $scale);
                    while ($stmt2->fetch()) {
                        //Put the results into an array
                        $establishmentLocationArray[] = ["username" => $username1, 
                            "establishmentName" => $establishmentName, "latitude" => $latitude,
                            "longitude" => $longitude, "review" => $review, "scale" =>$scale];
                    }
                }
                $stmt2->close();
            }
            
            //Query to get establishment image from establishment_gallery
            $query3 = "SELECT * FROM establishment_gallery WHERE username = ?";
            $establishmentGalleryArray = array();
            if ($stmt3 = $mysqli->prepare($query3)) {
                foreach ($user_arr as $key => $value) {
                    $stmt3->bind_param("s", $value['spotterRelated']);
                    $stmt3->execute();
                    $stmt3->bind_result($username1, $establishmentName, $photo);
                    while ($stmt3->fetch()) {
                        //Put the results into an array
                        $establishmentGalleryArray[] = ["username" => $username1, 
                            "establishmentName" => $establishmentName, "photo" => $photo];
                    }
                }
                $stmt3->close();
            }
            
            echo json_encode([$establishmentLocationArray, $establishmentGalleryArray]);
        }
    }
}
