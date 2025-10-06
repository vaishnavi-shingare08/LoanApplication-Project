<?php
$servername = "loan-app.c3a8yqwa6p76.ap-south-1.rds.amazonaws.com";
$username = "admin";
$password = "shingare12345";
$dbname = "quickloan_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>