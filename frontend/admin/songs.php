<?php
include('header.php');
$sql = "SELECT Songs.Song_ID,Songs.Title AS SongTitle, Artists.Artist_Name AS ArtistName, Albums.Title AS AlbumTitle, Genres.Genre_Name AS GenreName, Artists.Image AS ArtistImage
    FROM Songs JOIN Artists ON Songs.Artist_ID = Artists.Artist_ID 
    JOIN Albums ON Songs.Album_ID = Albums.Album_ID 
    JOIN Genres ON Songs.Genre_ID = Genres.Genre_ID";
$songs = $query->displayJoin($sql);
if (isset($_POST['addsong'])) {
    unset($_POST['addsong']);
    if (isset($_POST['Song_ID'])) {
        if ($query->edit("songs", "Song_ID", $_GET['id'], $_POST,"../assets/songs")) {
            header("songs.php");
        } 
    } else {
        if ($query->insert("songs", $_POST, "../assets/songs")) {
            header("songs.php");
        } 
    }
}
?>
<div class="container">
    <?php include('adminSidebar.php') ?>
    <div class="contents">
        <div class="inner-content">
            <div class="content-header">
                <div class="content-header-leftPart">
                    <h2>Songs</h2>
                    <h4>Dashboard • Songs</h4>
                </div>
                <div class="content-header-rightPart">
                    <img src="../assets/adminImgs/songs.png" alt="">
                </div>
            </div>
            <div class="content-upper-body">
                <div class="searchBox">
                    <form action="" method="get">
                        <input type="text" 
                        name="search"
                        value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>"
                        placeholder="Enter something to search">
                        <button><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="addBtn" onclick="togglePopup(event)">Add Songs</div>
            </div>
            <div class="content-lower-body">
            <?php 
                if (isset($_GET['search'])) {
                    $searchWord = $_GET['search'];
                    $searches = $query->displayJoin($sql.' WHERE Songs.Title LIKE "%'.$searchWord.'%"');
                    if (!empty($searches)){
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Artist</th>
                            <th>Genre</th>
                            <th>Album</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=0; foreach($searches as $search) :  ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= $search['SongTitle'] ?></td>
                            <td><?= $search['ArtistName'] ?></td>
                            <td><?= $search['GenreName'] ?></td>
                            <td><?= $search['AlbumTitle'] ?></td>
                            <td><img src="../assets/artists/<?= $search['ArtistImage'] ?>" alt="image" style="width:50px; height:50px;"></td>
                            <td class="actionSection">
                                    <a href="songDelete.php?id=<?=$search['Song_ID']?>">
                                        <div class="actionBtns"><i class="fas fa-trash"></i></div>
                                    </a> 
                                    <a href="songs.php?id=<?=$search['Song_ID']?>">
                                        <div class="actionBtns" id="actionEdit"><i class="fas fa-edit"></i></div>
                                    </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php } else echo "No Data Found"; 
                    }else{
                ?>
                                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Artist</th>
                            <th>Genre</th>
                            <th>Album</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=0; foreach($songs as $song) :  ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= $song['SongTitle'] ?></td>
                            <td><?= $song['ArtistName'] ?></td>
                            <td><?= $song['GenreName'] ?></td>
                            <td><?= $song['AlbumTitle'] ?></td>
                            <td><img src="../assets/artists/<?= $song['ArtistImage'] ?>" alt="image" style="width:50px; height:50px;"></td>
                            <td class="actionSection">
                                    <a href="songDelete.php?id=<?=$song['Song_ID']?>">
                                        <div class="actionBtns"><i class="fas fa-trash"></i></div>
                                    </a> 
                                    <a href="songs.php?id=<?=$song['Song_ID']?>">
                                        <div class="actionBtns" id="actionEdit"><i class="fas fa-edit"></i></div>
                                    </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- for popup -->
<!-- for popup -->
<div class="popup<?php echo isset($_GET['id']) ? ' active' : ''; ?>">
    <div class="overlay"></div>
    <div class="content">
        <a href="songs.php"><div class="close-btn" id="close-btn" onclick="togglePopup(event)">&times;</div></a>
        <br>
        <div class="main-popup-content" >
            <h2>Song Form</h2>
            <form  action="" id="registerForm" method="post" enctype="multipart/form-data">
                <?php if (isset($_GET['id'])) { 
                    $edit = $query->fetchData("songs", "Song_ID",$_GET['id']);
                ?>
                    <input type="hidden" name="Song_ID" value="<?=$_GET['id']?>">
                    
                <?php } ?>
                <label for="Title">Song Name</label><br>
                <input type="text" name="Title" placeholder="Enter Your song Name" value="<?= isset($_GET['id']) ? $edit[0]['Title'] : '' ?>"><br>
                <label for="genre">Genre</label><br>
                <select name="Genre_ID">
                    <?php 
                        $genres = $query->display("genres"); 
                        foreach ($genres as $genre):
                    ?>        
                        <option value="<?=$genre['Genre_ID']?>" <?= isset($_GET['id']) && $edit[0]['Genre_ID']==$genre['Genre_ID'] ? 'selected' : '' ?>><?=$genre['Genre_Name']?></option>
                    <?php endforeach; ?>
                </select><br>
                <label for="artist">Artist</label><br>
                <select name="Artist_ID">
                    <?php 
                        $artists = $query->display("artists"); 
                        foreach ($artists as $artist):
                    ?>        
                        <option value="<?=$artist['Artist_ID']?>" <?= isset($_GET['id']) && $edit[0]['Artist_ID']==$artist['Artist_ID'] ? 'selected' : '' ?>><?=$artist['Artist_Name']?></option>
                    <?php endforeach; ?>
                </select><br>
                <label for="album">Albums</label><br>
                <select name="Album_ID">
                    <?php 
                        $albums = $query->display("albums"); 
                        foreach ($albums as $album):
                    ?>        
                        <option value="<?=$album['Album_ID']?>" <?= isset($_GET['id']) && $edit[0]['Album_ID']==$album['Album_ID'] ? 'selected' : '' ?>><?=$album['Title']?></option>
                    <?php endforeach; ?>
                </select>
                <label for="audio">Audio File</label><br>
                <input type="file" name="audio"><br>
                <button name="addsong">Submit</button>
            </form>
        </div>
    <?php 

    ?>
    </div>
</div>
<script src="../js/adminPopup.js"></script>
<?php include('footer.php') ?>