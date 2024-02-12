<?php

$host = "localhost";
$dbname = "expense_db";
$username = "root";
$password = "";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}
$sqli="ALTER TABLE users
ADD COLUMN profile_image VARCHAR(255)";

return $mysqli;