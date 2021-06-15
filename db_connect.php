<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "hr"; // Nom de la base de donnée à renseigner

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
// echo "Connected successfully";