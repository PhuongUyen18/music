<?php 
    include('header.php');
    $artist = $query->fetchData("artists", "Artist_ID",$_GET['id']);
    $artistImg = $artist[0]['Image'];
    if ($query->delete("artists", "Artist_ID", $_GET['id'])) {
        $query->deleteImg($artistImg,'../assets/artists');
        header("location:artists.php");
    }
?>

