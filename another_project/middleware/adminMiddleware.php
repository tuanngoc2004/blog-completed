<?php
include('../functions/myFuntions.php');

if(isset($_SESSION['auth']))
{
    if($_SESSION['role_as'] != 1)
    {
        redirect("../index.php", "You are not authorized to access this page.");
        // $_SESSION['message'] = "You are not authorized to access this page.";
        // header('Location: ../index.php');
    }
}
else
{
    redirect("../login.php", "Login to Continue");
    // $_SESSION['message'] = "Login to Continue";
    // header('Location: ../login.php');
}


if(!isset($_SESSION['auth']))
{
    header('Location: ../login.php');
    exit();
}

?>