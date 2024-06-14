<?php 
    include('../../backend/query.php');
    $query= new dbQuery;
    $query->sessionCheck();
    //getting the userId
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $userId = (int)$_SESSION['id'];
        $songId = (int)$_POST['songId'];
        if ($query->checkLikeDislike($songId,$userId)) {
            //if the song is found ie the song is liked perform dislike function
            $query->dislikeSong($songId,$userId);
        }else{ 
            //if the song is found ie the song is liked perform like function
            $query->likeSong($songId,$userId);
        }
    }

?>