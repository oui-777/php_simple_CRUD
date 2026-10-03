<?php
//16.clear sessions
session_start();

// Check if the user is logged in
if(isset($_SESSION['session_user_id'])) {
    // Destroy the session and redirect to login page
    session_destroy();
    unset($_SESSION['session_user_id']);
    unset($_SESSION['session_user_name']);
}
    header("Location: login.php");
    exit();

?>



