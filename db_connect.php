<?php
  // This file will be included at the start of all other files in the site
  // It includes code to connect to the database server, but could be expanded
  // to include other things that are needed across multiple files in the site!

  // Connect to database server
  if (isset($_SESSION['username']))
  {
    header("Location:list_threads.php");
    exit;
  }
  session_start();
  try
  { 
    $db = new PDO('mysql:host=localhost;port=6033;dbname=iwd_forum', 'root', '');
    
    // Disable emulation mode to prevent multiple queries
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  }
  catch (PDOException $e) 
  {
    echo 'Error connecting to database server:<br />';
    echo $e->getMessage();
    exit;
  } 
  function log_event($event_type, $event_details, $username)
        {
            global $db;
            $log_stmt = $db->prepare("INSERT INTO log (ip_address, event_type, event_details, username) VALUES (?,?,?,?)");
            $log_stmt->execute([$_SERVER['REMOTE_ADDR'], $event_type, $event_details, $username]);
        }
?>