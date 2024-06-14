<?php 
    include('../../backend/query.php');
    $query = new dbQuery;
    $query->sessionCheck();
    $playlists= $query->displayJoin("SELECT * FROM playlists WHERE User_ID = ".$_SESSION['id']);
    if (!empty($playlists)){
    foreach ($playlists as $playlist):
?>  
        <option value="<?=$playlist['Playlist_ID']?>"><?=$playlist['Playlist_Name']?></option>
<?php 
    endforeach; 
    } else{
        "Please create a playlist first";
    }
?>