<?php
require 'config/database.php';

//get form data if submit button was click
if(isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
    // echo $firstname,$lastname,$username,$email,$createpassword,$confirmpassword;
    // var_dump($avatar);

    // validate input values
    if(!$firstname) {
        $_SESSION['add-user'] = "Please enter first name";
    } elseif(!$lastname) {
        $_SESSION['add-user'] = "Please enter last name";
    }
    elseif(!$username) {
        $_SESSION['add-user'] = "Please enter user name";
    }
    elseif(!$email) {
        $_SESSION['add-user'] = "Please enter email";
    }
    elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add-user'] = "pass must 8+";
    }
    elseif(!$avatar['name']) {
        $_SESSION['add-user'] = "Please add ava";
    } else {
        //check if pass don't match
        if ($createpassword !== $confirmpassword){
            $_SESSION['add-user'] = "Pass do not match";
        }else{
            //hass pass
            $hashed_password=password_hash($createpassword,PASSWORD_DEFAULT);
           
            //check if username or email already exist database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection,$user_check_query);
            if(mysqli_num_rows($user_check_result) > 0){
                $_SESSION['add-user'] = "Username or Email already exits";
            } else {
                // WORK ON Avatar
                //rename avatar
                $time = time();  //make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' .$avatar_name;

                //make sure file is an image
                $allowed_files = ['png', 'jpg' , 'jpeg'];
                $extention = explode('.', $avatar_name);
                $extention =end($extention);
                if(in_array($extention,$allowed_files)){
                    //make sure image is not too large (1mb+)
                    if($avatar['size'] < 1000000) {
                        // upload avatar
                        move_uploaded_file($avatar_tmp_name,$avatar_destination_path);
                    }else {
                        $_SESSION['add-user'] = "File size too big. should less than 1mb";
                    }
                } else{
                    $_SESSION['add-user'] = "File shoule be png,..";
                }
            }
        }
    }

    //redirect back to signup bag eif there was any problem
    if(isset($_SESSION['add-user'])){
        // back form data back to signup page
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . '/admin/add-user.php');
        die();
    } else {
        // insert new user into users table
        $insert_user_query = "INSERT INTO users SET firstname = '$firstname', lastname = '$lastname',
        username = '$username', email = '$email', password = '$hashed_password', avatar = '$avatar_name',
        is_admin = $is_admin";
        // $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) 
        // VALUES ('$firstname','$lastname','$username','$email','$hashed_password','$avatar_name',0)";

        $insert_user_result = mysqli_query($connection, $insert_user_query);

        if(!mysqli_errno($connection)){
            //redirectto login page with success masage
            $_SESSION['add-user-success'] = "New user $firstname $lastname added successfuly.";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }
}else {
    //if button wasn't click
    header('location: '. ROOT_URL . 'admin/add-user.php');
    die();
}
