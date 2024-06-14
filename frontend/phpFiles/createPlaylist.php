<?php
    include('../../backend/query.php');
    $query= new dbQuery;
    $query->sessionCheck();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // echo "User id is :".$_POST['User_ID']."<br>";
        // echo "Playlist name is :".$_POST['Playlist_Name'];
        if (!empty($_POST)) {
            if($query->insert("playlists",$_POST,'')){
                echo "Playlist Successfully Created";
            }else{
                echo "Error Creating Playlist";
            }
        }
    }
?>