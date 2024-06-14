<?php
include('../../backend/query.php');
$query = new dbQuery;
$query->sessionCheck();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "SELECT playlist_songs.*, songs.Title, 
    Artists.Artist_Name, Artists.Image AS ArtistImage, 
    Genres.Genre_Name, Albums.Title AS AlbumTitle FROM playlist_songs
    INNER JOIN songs ON playlist_songs.Song_ID = songs.Song_ID 
    INNER JOIN Artists ON songs.Artist_ID = Artists.Artist_ID 
    INNER JOIN Genres ON songs.Genre_ID = Genres.Genre_ID 
    INNER JOIN Albums ON songs.Album_ID = Albums.Album_ID 
    WHERE playlist_songs.Playlist_ID = {$_POST['playlistID']};";

    $songs = $query->displayJoin($sql);
    $i = 0;
    if (!empty($songs)) {
        foreach ($songs as $song) {

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
            <td>
                <i class='fas fa-trash' id="<?=$song['Song_ID']?>" onclick="deletePlaylistSong(event)"></i>
            </td>
        </tr>
<?php
        }
    } else {
        echo "You haven't added any songs to your playlist yet";
    }
}
?>
