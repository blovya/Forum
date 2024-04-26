<?php
    require 'db_connect.php';
    if(!$_SESSION['username'] AND ($_SESSION['access_level'] !='admin'))
	{
		header("Location:login.php");
		exit;
	}
    //if (($_SESSION['access_level'] =='admin'))


    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>View Log</title>
        <style>
            table {border-collapse:collapse;}
            td, th {border: 1px solid black; padding: 5px;}
        </style>
    </head>
    <body>
        <h2>Event Log:</h2>
        <table>
            <tr>
                <th>Log Date</th>
                <th>IP Address</th>
                <th>Username</th>
                <th>Event Type</th>
                <th>Event Details</th>
            </tr>
            <?php
            $stmt=$db->prepare("SELECT log_date, ip_address, event_type, event_details, username FROM log 
                                ORDER BY log_date DESC ");
            $stmt->execute();
            $data=$stmt->fetchAll();
            if (count($data)>0)
            {
            foreach($data as $row)
            {
                echo '<tr>
                        <td>'.$row['log_date'].'</td>
                        <td>'.$row['ip_address'].'</td>
                        <td>'.$row['username'].'</td>
                        <td>'.$row['event_type'].'</td>
                        <td>'.$row['event_details'].'</td>
                    </tr>';
            }
            }
            else
                echo '<tr><td colspan="5">No data logged yet.</td></tr>';
            ?>
        </table>
        <p><a href="list_threads.php">Go to Threads!</a></p></b>
        <a href="logout.php">Log Out!</a>
</body> 
</html>

