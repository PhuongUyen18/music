<?php
include('../../backend/query.php');
$query = new dbQuery;
$query->sessionCheck();
$sql = "SELECT songs.Song_ID, songs.Title, Artists.Artist_Name, Artists.Image AS ArtistImage, 
        Genres.Genre_Name, Albums.Title AS AlbumTitle ,likedsongs.timestamp
        FROM likedsongs 
        INNER JOIN songs ON likedsongs.Song_ID = songs.Song_ID 
        INNER JOIN Artists ON songs.Artist_ID = Artists.Artist_ID 
        INNER JOIN Genres ON songs.Genre_ID = Genres.Genre_ID 
        INNER JOIN Albums ON songs.Album_ID = Albums.Album_ID 
        WHERE likedsongs.User_ID = {$_SESSION['id']} ORDER BY timestamp DESC";

$songs = $query->displayJoin($sql);

$i = 0;
if (!empty($songs)) {
    foreach ($songs as $song) {
        // this is a dynamic element so I added an onclick function again so the event can be delegated
        $likeDislikeStyle = $query->checkLikeDislike($song['Song_ID'], $_SESSION['id']) ? "color: #284edb;" : "color:white;";
?>
        <tr onclick='songFunction(this)'>
            <td><?=++$i?></td>
            <td><?=$song['Title']?></td>
            <td><?=$song['Artist_Name']?></td>
            <td><?=$song['Genre_Name']?></td>
            <td><?=$song['AlbumTitle']?></td>
            <td><img src='assets/artists/<?=$song['ArtistImage']?>' alt='image' style='width:50px; height:50px;'></td>
            <td onclick='likeDislikeFn(event);' class='likeDislike'>
                <span style='display:none;'><?=$song['Song_ID']?></span>
                <i class='fa-solid fa-heart' style='<?=$likeDislikeStyle?>'></i>
            </td>
            <td onclick="togglePopup(event)">
                <span style="display:none;"><?=$song['Song_ID']?></span>
                <i class='fa-regular fa-square-plus'></i>
            </td>
        </tr>
<?php
    }
} else {
    echo "You haven't liked any songs yet";
}

?>