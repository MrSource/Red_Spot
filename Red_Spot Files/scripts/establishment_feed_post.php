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
    if ($theFunction == "getEstablishmentFeed") {
        if (isset($_POST['theData'])) {
            //First table update
            $theData = json_decode($_POST['theData']);
            $username = $theData->username;
            $establishmentInformationArray = array();
            //Temporary join query
            //$query = "SELECT `spotterRelated` FROM spotters_relationship WHERE `spotterUsername` = ? AND relation = 'User-Establishment' INNER JOIN `establishment_information` on spotters_relationship.username = establishment_information.username";
            //Query to get establishment Information
            $query = "SELECT `establishment_information`.* FROM `establishment_information` JOIN `spotters_relationship` "
                    . "on `establishment_information`.`username` = `spotters_relationship`.`spotterRelated` "
                    . "WHERE `spotters_relationship`.`spotterUsername` = ? "
                    . "AND `spotters_relationship`.`relation` = 'User-Establishment'";
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->bind_result($username, $establishmentName, $schedule, $parking, $information, $telephone, 
                        $category, $latitude, $longitude, $photo);
                while ($stmt->fetch()) {
                    //Put the results into an array
                    $establishmentInformationArray[] = ["username" => $username, "establishmentName" => $establishmentName, "schedule" => $schedule, 
                        "parking" => $parking, "information" => $information, "telephone" => $telephone, 
                        "category" => $category, "latitude" => $latitude, "longitude" => $longitude, "photo" => $photo];
                }
                //Close the prepared statement
                $stmt->close();
            }
            echo json_encode($establishmentInformationArray);
        }
    }
}
