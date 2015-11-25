<?php
//Erase array
$_SESSION = array(); 
//Destroy session
session_destroy(); 
echo "Logged Out";
?>