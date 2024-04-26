<?php
require 'db_connect.php';
if (!isset($_SESSION['username']))
  header("Location:list_threads.php");
// If the request includes form data...
if (isset($_POST['submit']))
{ // Validate and process the form

  // This array will be used to store validation error messages
  // When an error is detected, the relevant message is added to the array
  $errors = [];
  
  
  // The following "if" statements validate the form data
  // By using separate "if" statements, we always check all of the fields,
  // rather than stopping after finding a single error

  // Tests if the title field is empty or entirely whitespace
  if (trim($_POST['title']) == '')
  {
    $errors[] = 'Title not specified.';
  }
  
  // Tests if the content field is empty or entirely whitespace
  if (trim($_POST['content']) == '')
  {
    $errors[] = 'Content not specified.';
  }

  // Tests if a forum has not been selected (and hence not available)
  if (!isset($_POST['forum_id'])) 
  {
    $errors[] = 'Forum not selected.';
  }


  // If the error message array contains any items, it evaluates to True
  if ($errors)
  { // Display all error messages and link back to form
    foreach ($errors as $error)
    {
      echo '<p>'.$error.'</p>';
    }
   
    echo '<a href="javascript: window.history.back()">Return to form</a>';
  }
  else
  { // Validation successful (code to process the data would go here)
    $stmt=$db->prepare("UPDATE thread SET title=?, content=?, forum_id=?
                        WHERE thread_id=? AND username=?");
    $result=$stmt->execute( [$_POST['title'], $_POST['content'], $_POST['forum_id'], $_POST['thread_id'], $_SESSION['username']] );
    if ($result)
        {
          echo 'Posting Thread is successful!';
          header('Location:view_thread.php?id='.$_POST['thread_id']);
        }
      else
        echo 'Error';
  }
}
else
{ // Show message if the form has not been submitted
  echo 'Please submit the <a href="new_thread_form.php">form</a>.';
}
?>