<?php
  require 'db_connect.php';

  // Select details of specified thread
  // Since the user could tamper with the URL data, a prepared statement is used
  $stmt = $db->prepare("SELECT * FROM thread 
                        LEFT JOIN forum
                        ON thread.forum_id=forum.forum_id 
                        WHERE thread_id = ?");
  $stmt->execute( [$_GET['id']] );
  $thread = $stmt->fetch();
  
  if (!isset($_GET['id']) || !ctype_digit($_GET['id']) || !$thread)
  { // If no data (no thread with that ID in the database)
    header("Location:list_threads.php");
    exit;  
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo htmlentities($thread['title'])?></title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="View thread page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
    <script>
      function validateForm() {
        
        // Create a variable to refer to the form
        var form = document.reply;
      
        // Tests if the reply is empty
        if (form.reply.value.trim() == '') {
          alert('Cannot post an empty reply.');
          return false;
        }
    	
      }
    </script>
  </head>

  <body>
    <h3>View Thread</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>
		<?php
    if (isset($_SESSION['username']))
    {
      if (($_SESSION['access_level'] =='admin') AND ($_SESSION['username']==$thread['username']))
      {
        echo '<a href="edit_thread_form.php?id='.$_GET['id'].'"> Edit Thread</a> | ';
        echo '<a onclick="return confirm(\'Are you sure you want to delete this thread?\')"
              href="delete_thread.php?id='.$_GET['id'].'"> Delete Thread</a>';
      }
      else if ($_SESSION['username']==$thread['username'])
      {
        echo '<a href="edit_thread_form.php?id='.$_GET['id'].'">Edit Thread</a> | ';
        echo '<a onclick="return confirm(\'Are you sure you want to delete this thread?\')"
              href="delete_thread.php?id='.$_GET['id'].'">Delete Thread</a>';
      }
      else if ($_SESSION['access_level'] =='admin')
       {
        echo '<a onclick="return confirm(\'Are you sure you want to delete this thread?\')"
              href="delete_thread.php?id='.$_GET['id'].'"> Delete Thread</a>';
       }
      }
      // Display the thread's details
      echo ('<h4>'.htmlentities($thread['title']).'</h4>');
      echo '<p><small><em>Posted by <a href="view_profile.php?username='.$thread['username'].'">'.$thread['username'].'</a> in <a href="list_threads.php?forum_id='.$thread['forum_id'].'">'.$thread['forum_name'].'</a> on '.$thread['post_date'].'</small></p>';
      echo '<p>'.nl2br(htmlentities($thread['content'])).'</p>';
      echo '<hr>';

      $stmt = $db->prepare("SELECT username, post_date, content
                                FROM reply
                                WHERE thread_id = ?
                                ORDER BY post_date ASC");
                                
      $stmt->execute([$_GET['id']]);
      $result_data = $stmt->fetchAll();
      if (count($result_data) > 0)
      { 
        foreach($result_data as $row)
            {
              echo '<p><small><a href="view_profile.php?username='.$row['username'].'">'.$row['username'].'</a> '.$row['post_date'].'...</small>';
              echo '<br />'.nl2br(htmlentities($row['content'])).'</p>';
            }
      }
      else
        echo '<p>No replies posted yet.</p>';
      
    if (isset($_SESSION['username']))
    {
      echo '<form name ="reply" method="post" action="reply.php" onsubmit="return ValidateForm()">';
      echo '<textarea name="reply" style="width: 400px; height: 50px"></textarea>';

      echo '<input type="submit" name="submit" value="Reply" />';
      echo '<input type="hidden" name="thread_id" value="'.$_GET['id'].'"/>';
      echo '</form>';
    }
    ?>
  </body>
</html>
