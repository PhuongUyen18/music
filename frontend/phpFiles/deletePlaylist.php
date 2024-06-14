<?php
    include('../../backend/query.php');
    $query= new dbQuery;
    $query->sessionCheck();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $query->delete("playlists","Playlist_ID",$_POST['playlistID']);
    }
?>