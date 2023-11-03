<?php
require 'config/constants.php';
//destroy all session and redirect
session_destroy();
header('location: ' . ROOT_URL);
die();