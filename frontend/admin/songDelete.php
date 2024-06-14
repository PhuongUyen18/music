<?php 
    include('header.php');
    $song = $query->fetchData("songs", "Song_ID",$_GET['id']);
    $audio= $song[0]['Title'].'mp3';
    if ($query->delete("songs", "Song_ID", $_GET['id'])) {
        $query->deleteImg($audio,'../assets/songs');
        header("location:songs.php");
    }
?>

