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
    <meta name="description" content="Edit thread of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>

  <body>
    <h3>Edit Thread</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>
    <a href='view_thread.php'>Go Back</a>
    <form name="edit_thread" method="post" action="edit_thread.php" onsubmit="return validateForm()">
    <?php
    $stmt = $db->prepare("SELECT * FROM thread 
                        LEFT JOIN forum
                        ON thread.forum_id=forum.forum_id 
                        WHERE thread_id = ? AND username = ?");
  $stmt->execute( [$_GET['id'], $_SESSION['username']] );
  $thread = $stmt->fetch();
  
  if (!isset($_GET['id']) || !ctype_digit($_GET['id']) || !$thread)
  { // If no data (no thread with that ID in the database)
    header("Location:list_threads.php");
    exit;  
  }
  ?>
  <input type="hidden" name="thread_id" value=<?php echo $_GET['id'] ?>/>
  <p><strong>Title:</strong><br />
        <textarea type="text" name="title" style="width: 398px; height: 15px"><?= $thread['title']?></textarea>
      </p>

      <p><strong>Content:</strong><br />
        <textarea name="content" style="width: 400px; height: 150px"><?= $thread['content']?></textarea>
      </p>

      <p><strong>Select Forum:</strong>
        <select name="forum_id" style="width: 295px;">
          <option value="<? $thread['forum_name'] ?>" selected disabled>Select forum name</option>
          <?php  
            // Select details of all forums
            $result = $db->query("SELECT * FROM forum ORDER BY forum_id");
      
            // Loop through each forum to generate an option of the drop-down list
            foreach($result as $row)
            {
              if ($row['forum_id'] == $thread['forum_id'])
              {
                echo '<option value="'.$row['forum_id'].'" selected >'.$row['forum_name'].'</option>';
              }
              else
              {
                echo '<option value="'.$row['forum_id'].'">'.$row['forum_name'].'</option>';
              }
              //echo '<option value="'.$row['forum_id'].'">'.$row['forum_name'].'</option>';
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