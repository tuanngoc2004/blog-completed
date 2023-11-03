<?php

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "tqblibrary";

    $con = mysqli_connect($host, $username, $password, $database);

    if(!$con)
    {
        die("Conntection Failed: ".mysqli_connect_error());
    }
    else
    {
        // echo "Conntection Success";
    }
?>