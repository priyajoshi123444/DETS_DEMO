<?php
    $conn=mysqli_connect("localhost","root","","expense_db") or die("connection failed".mysqli_error($conn)); 

// $sqli="ALTER TABLE users
//     ADD COLUMN reset_token VARCHAR(255),
//     ADD COLUMN token_expiry TIMESTAMP,
//     ADD COLUMN reset_status INT DEFAULT 0,
//     ADD COLUMN hashed_reset_token VARCHAR(255)";

$sqli="CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    gender VARCHAR(10),
    mobile_number VARCHAR(15),
    profile_image VARCHAR(255),
    reset_token VARCHAR(255),
    reset_token_expiry DATETIME,
    reset_status BOOLEAN DEFAULT 0,
    last_password_change DATETIME
)";
   


if(mysqli_query($conn,$sqli)>0)
{
echo "table created";
}
else
{
echo "error:".mysqli_error($conn);
}
	
?>