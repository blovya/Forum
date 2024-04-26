<?php
require 'db_connect.php';
if (!isset($_SESSION['username']))
  header("Location:list_threads.php");
if (isset($_POST['submit']))
{
    // Tests if the title field is empty or entirely whitespace
    if (trim($_POST['reply']) == '')
    {
        echo 'Reply cannot be empty';
        echo '<a href="javascript: window.history.back()">Return to form</a>';
        exit;
    }
    else
        $stmt=$db->prepare("INSERT INTO reply (username, content, thread_id) VALUES (?,?,?)");
        $result=$stmt->execute( [$_SESSION['username'], $_POST['reply'], $_POST['thread_id']] );
        header("Location:view_thread.php?id=".$_POST['thread_id']);
}
else
echo 'Submit the form first.';
?>
