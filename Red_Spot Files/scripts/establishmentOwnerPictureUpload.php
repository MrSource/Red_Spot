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

$return = Array('ok'=>TRUE);

$upload_folder ='../uploads/establishmentOwnerPics/';

$nombre_archivo = $_FILES['file']['name'];

$tipo_archivo = $_FILES['file']['type'];

$tamano_archivo = $_FILES['file']['size'];

$tmp_archivo = $_FILES['file']['tmp_name'];

$archivador = $upload_folder . '/' . $nombre_archivo;

//Check if our file is not bigger than 5 Megabytes
if($tamano_archivo > 5242880){
    $return = Array('ok' => FALSE, 'msg' => "File size exceeded", 'status' => 'error');
}
else{
    $files = scandir("../uploads/establishmentOwnerPics/");
    $fileExists = FALSE;
    foreach($files as $theFileName){
        if($theFileName == $nombre_archivo){
            $fileExists = TRUE;
        }
    }
    //Check if our file doesn't exists
    if($fileExists){
        $return = Array('ok' => FALSE, 'msg' => "The file already exists.", 'status' => 'error');
    }
    else{
        //Proceed to try to upload
         if (!move_uploaded_file($tmp_archivo, "../uploads/establishmentOwnerPics" . "/" . $nombre_archivo)) {
            $return = Array('ok' => FALSE, 'msg' => "There was an error while trying to upload the file.", 'status' => 'error');
         }
         else{
              $return = Array('ok' => FALSE, 'msg' => "File uploaded.", 'status' => 'error');
         } 
    }
}

echo json_encode($return);
?>

