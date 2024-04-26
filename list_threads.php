<?php
  require 'db_connect.php';
  if (isset($_SESSION['username']))
  {
    echo '<p>Welcome, '.$_SESSION['username'].' ('.$_SESSION['access_level'].')';
    echo '<br/><small><a href="logout.php">Log Out</a></small></p>';
  }
  else
  {
    echo '<p>You are not logged in.';
    echo '<br /><small><a href="login.php">Log In</a></small></p>';
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>List Threads</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="List threads page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>

  <body>
    <h3>List Threads</h3>
    <?php
    if (isset($_SESSION['access_level'])) 
    {
    if ($_SESSION['access_level'] =='admin')
      echo '<a href="view_log.php">View Logs Here!</a>'; 
    }
    if (isset($_SESSION['username']))
      echo '<p><a href="search_threads.php">Search Threads</a> | <a href="new_thread_form.php">New Thread</a></p>';
    else 
      echo '<p><a href="search_threads.php">Search Threads</a></p>';
    ?>
    <form name="list_threads" method="get" action="list_threads.php" >
      <p><input type="button" value="Show All Threads" onclick="window.location.href = 'list_threads.php'" /> or filter to
        <select name="forum_id">
          <option value="" selected disabled>Select a forum</option>
          <?php  
            // Select details of all forums
            $result = $db->query("SELECT * FROM forum ORDER BY forum_id");
            
            // Loop through each forum to generate an option of the drop-down list
            foreach($result as $row)
            {
              echo '<option value="'.$row['forum_id'].'">'.$row['forum_name'].'</option>';
              
              // If there is a forum_id in the URL data, assign the current forum's name to a variable to display later
              // (this simply saves us having to use a separate query to get the name of the selected forum)
              if (isset($_GET['forum_id']) && $_GET['forum_id'] == $row['forum_id'])
              {
                $current_forum_name = $row['forum_name'];
              }
            }
          ?>
        </select> <input type="submit" value="Filter" />
      </p>
    </form>
    
    <?php
      // Execute a query with or without a WHERE clause depending on whether there's a forum_id in the URL data
      if (isset($_GET['forum_id']))
      {
        echo '<h4>'.$current_forum_name.' Threads</h4>';
        
        $stmt = $db->prepare("SELECT thread_id, username, title, post_date, forum_name, thread.forum_id
                              FROM thread LEFT JOIN forum
                              ON thread.forum_id=forum.forum_id 
                              WHERE thread.forum_id = ? ORDER BY post_date DESC");

        $stmt->execute( [$_GET['forum_id']] );
      }
      else
      {
        echo '<h4>All Threads</h4>';
        
        $stmt = $db->prepare("SELECT thread_id, username, title, post_date, forum_name, thread.forum_id
                              FROM thread LEFT JOIN forum
                              ON thread.forum_id=forum.forum_id
                              ORDER BY post_date DESC");
                              
        $stmt->execute();
      }
      
      
      // Fetch all of the results as an array
      $result_data = $stmt->fetchAll();
      if (count($result_data) == 1)
        echo 'There is 1 thread.';
      if (count($result_data) > 1)
        echo 'There are '.count($result_data).' threads.';
      
      // Display results or a "no threads" message as appropriate
      if (count($result_data) > 0)
      {      
        // Loop through results to display links to threads
        foreach($result_data as $row)
        {
          echo '<p><a href="view_thread.php?id='.$row['thread_id'].'">'.$row['title'].'</a><br />';
          echo '<small>Posted by <a href="view_profile.php?username='.$row['username'].'">'.$row['username'].'</a> in <a href="list_threads.php?forum_id='.$row['forum_id'].'">'.$row['forum_name'].'</a> on '.$row['post_date'].'</small></p>';
        }
      }
      else
      {
        echo '<p>No threads posted.</p>';
      }
      //echo password_hash('Abc12345', PASSWORD_DEFAULT);
    ?>
  </body>
</html>