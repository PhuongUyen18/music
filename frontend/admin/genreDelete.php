<?php 
    include('header.php');
    $genre = $query->fetchData("genres", "Genre_ID",$_GET['id']);
    $genreImg = $genre[0]['Image'];
    if ($query->delete("genres", "Genre_ID", $_GET['id'])) {
        $query->deleteImg($genreImg,'../assets/genres');
        header("location:genre.php");
    }
?>

