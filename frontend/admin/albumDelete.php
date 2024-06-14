<?php 
    include('header.php');
    if ($query->delete("albums", "Album_ID", $_GET['id'])) {
        header("location:albums.php");
    }
?>

