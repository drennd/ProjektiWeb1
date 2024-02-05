<?php

//MYsqli
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "databaseprojektit";
//Lidhja me ane te sqli per vlerat e databazes
$conn = new mysqli($servername, $username, $password, $dbname);
//Kontrollon nese connection osht error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
