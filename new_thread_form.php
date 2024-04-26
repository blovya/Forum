<?php
  require 'db_connect.php';
  if (!isset($_SESSION['username']))
  header("Location:list_threads.php")

?>
<!DOCTYPE html>
<html>
  <head>
    <title>New Thread</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="New thread form of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
	  <script>
      function validateForm() {
        
        // Create a variable to refer to the form
        var form = document.new_thread;
      
        // Tests if the title is empty
        if (form.title.value.trim() == '') {
          alert('Title not specified.');
          return false;
        }
      
        // Tests if the content is empty
        if (form.content.value.trim() == '') {
          alert('Content not specified.');
          return false;
        }
      
        // Tests if a forum has not been selected
        if (form.forum_id.value == '') {
          alert('Forum not selected.');
          return false;
        }
      }
    </script>
  </head>

  <body>
    <h3>New Thread</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>
    <form name="new_thread" method="post" action="new_thread.php" onsubmit="return validateForm()">
      <p><strong>Title:</strong><br />
        <input type="text" name="title" style="width: 398px;" />
      </p>

      <p><strong>Content:</strong><br />
        <textarea name="content" style="width: 400px; height: 150px"></textarea>
      </p>

      <p><strong>Select Forum:</strong>
        <select name="forum_id" style="width: 295px;">
          <option value="" selected disabled>Select a Forum</option>
          <?php  
            // Select details of all forums
            $result = $db->query("SELECT * FROM forum ORDER BY forum_id");
      
            // Loop through each forum to generate an option of the drop-down list
            foreach($result as $row)
            {
              echo '<option value="'.$row['forum_id'].'">'.$row['forum_name'].'</option>';
            }
          ?>
        </select>
      </p>
	
      <p>
        <input type="submit" name="submit" value="Submit" />
      </p>
    </form>
  </body>
</html>