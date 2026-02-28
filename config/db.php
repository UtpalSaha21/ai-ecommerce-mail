<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ai_email_automation";

$conn = mysqli_connect($host,$username,$password,$database);

if(!$conn)
    {
        die("Database connection failed: ".mysqli_connect_error());
    }

?>