<?php
require 'config/constants.php';

//conect to the database
$connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_Name);

if(mysqli_error($connection)){
    die(mysqli_error($connection));
}