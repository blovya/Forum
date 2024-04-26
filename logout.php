<?php
    require 'db_connect.php';
    //session_start();
    session_destroy();
    log_event('Logout', NULL, $_SESSION['username']);
    //echo $_SESSION['username'];
    header('Location: list_threads.php');
?>