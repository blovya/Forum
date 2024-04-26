<?php
    require 'db_connect.php';
    if (isset($_POST['submit']))
    {
        $stmt=$db->prepare("SELECT * FROM user WHERE username=?");
        $stmt->execute( [$_POST['uname']] );
        $user=$stmt->fetch();
        if ($user && password_verify($_POST['pword'], $user['password']))
        {
            $_SESSION['username']=$user['username'];
            $_SESSION['access_level']=$user['access_level'];
            log_event('Login (Successful)', NULL, ''.$_POST['uname'].'');
            header('Location: list_threads.php');
            exit;
        }
        else
        {
            echo 'Invalid credentials. Try again.';
            log_event('Login (Failed)','username: '.$_POST['uname'].'', NULL);
        }
    }
/*
    if (isset($_POST['organiser_login']))
    {
        $stmt=$db->prepare("SELECT * FROM organiser WHERE username=?");
        $stmt->execute( [$_POST['username']] );
        $user=$stmt->fetch();
        if ($user && password_verify($_POST['password'], $user['password_hash']))
        {
            $_SESSION['username']=$user['username'];
            header('Location: volunteer_time_slot.php');
            log_event('Login (Organiser)', ''.$_POST['username'].' logged in');
            exit;
        }
        else
        {
            log_event('Failed Login (Organiser)', ''.$_POST['username'].' failed to log in');
            echo 'Invalid credentials. Try again.';
        }
    }*/
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="form_format.css" />
</head>
<body>
    <form method="post" action="login.php">
        <fieldset><legend>Log In</legend>
        <h3>User Login </h3>
        <label><span>Username:</span><input type="text" name="uname" /></label>
        <label><span>Password:</span><input type="password" name="pword" /></label>
        <br/>
        <input type="submit" name="submit" value="Log IN" class="middle" />
        </fieldset>
        <br>
        <p><a href="register_form.php">Register here!</a></p>
        <p><a href="list_threads.php">List Threads</a></p>
    </form>
</body>
</html>
