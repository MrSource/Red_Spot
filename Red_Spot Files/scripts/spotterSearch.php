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
require_once 'config.php';
include 'AccountClass.php';

//The query to get users like the written query
$query = "SELECT username, role FROM accounts WHERE username LIKE ?";
//Query to check for relationship
$query2 = "SELECT `spotterUsername`, `spotterRelated` FROM spotters_relationship WHERE ((`spotterUsername` = ? AND `spotterRelated` = ?) OR (`spotterUsername` = ? AND `spotterRelated` = ?))";
$stmt2 = $mysqli->prepare($query2);
//Prepare the query
$theQuery = "%" . $_POST['query'] . "%";
//Execure the first query
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $theQuery);
    $stmt->execute();
    $stmt->bind_result($username, $role);
    $user_arr = array();
    while ($stmt->fetch()) {
        //Put the results into an array
        $user_arr[] = ["username" => $username, "role" => $role];
    }
    //Close the prepared statement
    $stmt->close();
    
    //Get the current user
    $specificUser = $_POST['currentUser'];
    
    //Iterate through each of the found users in our query
    for ($i = 0; $i < count($user_arr); $i++) {
        //Execute the second query to find a relationship
        if ($stmt2) {
            $stmt2->bind_param("ssss", $user_arr[$i]['username'], $specificUser, $specificUser, $user_arr[$i]['username']);
            $stmt2->execute();
            $stmt2->store_result(); //Store the result so we can have the number of rows found
            $stmt2->bind_result($username1, $username2);
            while($stmt2->fetch()){
                //Check if the current fetched row has a spotter relationship established
                if(($specificUser == $username1 || $specificUser == $username2) && ($user_arr[$i]['username'] == $username1 || $user_arr[$i]['username'] == $username2)){
                    $user_arr[$i]["related"] = TRUE;
                }
                else{
                    $user_arr[$i]["related"] = FALSE;
                }
            }
            //Check if the number of rows returned by our query
            //is equal to zero which means that there are no related users to the current user
            if($stmt2->num_rows == 0){
                //In which case let's return a 'related' value of FALSE
                $user_arr[$i]["related"] = FALSE;
            }
            //Free the result so when we go back to the prepared statement and execute
            //it again we don't get our result mixed with the previous one.
            //Remember we are inside a for loop that loops through each of the found members in the database
            //that matches the searched query.
            $stmt2->free_result();
        } else {
            //There was an error
            echo $mysqli->error;
        }
    }
    $stmt2->close();
    $mysqli->close();
    echo json_encode($user_arr);
} else {
    //There was an error
    echo $mysqli->error;
}

//Check if we have a function set
if (isset($_POST['theFunction'])) {
    $theFunction = $_POST['theFunction'];
    //Are we asked to check for relationships?
    if ($theFunction == 'checkRelationships') {
        //First let's make sure we have data to work with
        if (isset($_POST['theData'])) {
            
        }
    }
}