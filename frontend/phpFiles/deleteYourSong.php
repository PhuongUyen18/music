<?php
    include('../../backend/query.php');
    $query= new dbQuery;
    $query->sessionCheck();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $song= $query->fetchData("songs","Song_ID",$_POST['Song_ID']);
     $query->deleteImg($song[0]['Title'].".mp3",'../assets/songs');
       if($query->delete("songs","Song_ID",$_POST['Song_ID'])) {
            echo "deleted";
       } else {
            echo "error";
       }
    }
?>