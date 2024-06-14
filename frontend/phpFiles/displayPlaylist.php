<?php
    include('../../backend/query.php');
    $query= new dbQuery;
    $query->sessionCheck();
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM playlists WHERE User_ID = $id ORDER BY Created_Date DESC";
    
    $playlists = $query->displayJoin($sql);
    if (!empty($playlists)) {
    foreach ($playlists as $playlist) {
    $playlistName = ucfirst($playlist['Playlist_Name']);//making the first letter uppercase
?>
        <div title='playlist-content' onclick='openDiv(this)' 
        class='nav-section-members playlist-members'>
            <div id="<?=$playlist['Playlist_ID']?>" onclick="showPlaylistSongs(event)"><?=$playlistName?></div> 
            <div>
                <i onclick='deletePlaylist(event)' id="<?=$playlist['Playlist_ID']?>" class='fas fa-trash'></i>
            </div>
        </div>
<?php 
        }
    }
    
?>