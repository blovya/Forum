<?php
    require 'db_connect.php';
    if(!$_SESSION['username'])
	{
		header("Location:list_threads.php");
		exit;
	}
    if ($_SESSION['access_level']=="admin")
    {
        $stmt=$db->prepare("DELETE FROM thread WHERE thread_id=?");
        $result=$stmt->execute([$_GET['id']] );
        if ($result)
        {
            log_event('Delete Thread','thread_id: '.$_GET['id'].'' , $_SESSION['username']);
            header('Location:list_threads.php');
        }
        else
        {
            echo 'Cannot delete thread.';
        }  
    }
    else if ($_SESSION['access_level']=="member")
    {
        $stmt=$db->prepare("DELETE FROM thread WHERE thread_id=? AND username=?");
        $result=$stmt->execute([$_GET['id'], $_SESSION['username']] );
        if ($result)
        {
            log_event('Delete Thread','thread_id: '.$_GET['id'].'' , $_SESSION['username']);
            header('Location:list_threads.php');
        }
        else
        {
            echo 'Cannot delete thread.';
        }  
    }