<?php
  require 'db_connect.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Search Threads</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="Search threads page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>

  <body>
    <h3>Search Threads</h3>
    <?php
    if (isset($_SESSION['username']))
    echo '<p><a href="list_threads.php">List</a> | <a href="new_thread_form.php">New Thread</a></p>';
    else
    echo '<p><a href="list_threads.php">List Threads</a></p>';
    ?>
    <form name="search_threads" method="get" action="search_threads.php" >
      <p>Search: <input type="text" name="search_term" placeholder="Enter search term..." autofocus /> <input type="submit" value="Submit" /></p>
    </form>
    
    <?php
      // Execute a query if there's a search term in the URL data
      if (isset($_GET['search_term']))
      {
        echo '<h4>Search results for "'.$_GET['search_term'].'"</h4>';
        
        // Put wildcard characters on each end of the search term
        $search_term = '%'.$_GET['search_term'].'%';
        
        $stmt = $db->prepare("SELECT thread_id, username, title, post_date, forum_name, thread.forum_id
                              FROM thread LEFT JOIN forum
                              ON thread.forum_id=forum.forum_id
                              WHERE title LIKE ? OR content LIKE ? ORDER BY post_date DESC");

        // Provide the same value for both placeholders to search the title and content columns
        $stmt->execute( [$search_term, $search_term] );
        
        
        // Fetch all of the results as an array
        $result_data = $stmt->fetchAll();
        if (count($result_data) == 1)
          echo 'There is 1 thread.';
        if (count($result_data) > 1)
          echo 'There are '.count($result_data).' threads.';
        
        // Display results or a "no results" message as appropriate
        if (count($result_data) > 0)
        {          
          // Loop through results to display links to threads
          foreach($result_data as $row)
          {
            echo '<p><a href="view_thread.php?id='.$row['thread_id'].'">'.$row['title'].'</a><br />';
            echo '<small>Posted by <a href="view_profile.php?username='.$row['username'].'">'.$row['username'].'</a> in <a href="list_threads.php?forum_id='.$row['forum_id'].'">'.$row['forum_name'].'</a> on '.$row['post_date'].' </small></p>';
          }
        }
        else
        {
          echo '<p>No results found.</p>';
        }
      }
    ?>
  </body>
</html>