<?php
  require 'db_connect.php';

  // Select details of specified thread
  // Since the user could tamper with the URL data, a prepared statement is used
  $stmt = $db->prepare("SELECT real_name, YEAR(dob) AS year, COUNT(thread_id) AS posted_threads
                        FROM user LEFT JOIN thread 
                        ON user.username=thread.username
                        WHERE user.username= ?");
  $stmt->execute( [$_GET['username']] );
  $user = $stmt->fetch();
  
  if (!isset($_GET['username']) || !$user)
  { // If no data (no thread with that ID in the database)
    header("Location:list_threads.php");
    exit;  
  }
?>
<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h3>Viewing Profile of <?php echo $_GET['username']  ?></h3>
    <?php 
    if (empty($user['real_name']))
        echo '<p>Real Name:<em> Not Disclosed</em></p>';
    else 
        echo '<p>Real Name: '.$user['real_name'].'</p>';
    echo '<p>Born in: '.$user['year'].'</p>';
    echo '<p>Post Count: '.$user['posted_threads'].'</p>';
    
    ?>
    <a href="javascript: history.back()">Go back</a>
  </body>
</html>