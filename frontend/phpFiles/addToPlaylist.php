<?php
    include('../../backend/query.php');
    $query= new dbQuery;
    $query->sessionCheck();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST)) {
            if ($query->checkPlaylistSong($_POST['Song_ID'],$_POST['Playlist_ID'])) {
                echo "Failed";
            }else{
                if($query->insert("playlist_songs",$_POST,'')){
                    echo "Success";
                }
            }
            
        }
    }
?>