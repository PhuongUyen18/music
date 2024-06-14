<?php
    include('header.php');
    $artists = $query->display("artists");
    
    if (isset($_POST['addArtist'])) {
        unset($_POST['addArtist']);
        if (isset($_POST['Artist_ID'])) {
            if ($query->edit("artists", "Artist_ID", $_GET['id'], $_POST,"../assets/artists")) {
                header("location:artists.php");
            } 
        } else {
            if ($query->insert("artists", $_POST, "../assets/artists")) {
                header("location:artists.php");
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
                    <h2>Artists</h2>
                    <h4>Dashboard • Artists</h4>
                </div>
                <div class="content-header-rightPart">
                    <img src="../assets/adminImgs/artists.png" style="width:140px; height:120px;">
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
                <div class="addBtn" onclick="togglePopup(event)">Add artists</div>
            </div>
            <div class="content-lower-body">
            <?php 
                if (isset($_GET['search'])) {
                    $searches = $query->searchf("artists","Artist_Name",$_GET['search']);
                    if (!empty($searches)){
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Artist Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=0; foreach ($searches as $search) {?>
                            <tr>
                                <td><?=++$i?></td>
                                <td><?=$search['Artist_Name']?></td>
                                <td><img src="../assets/artists/<?=$search['Image']?>" width="50" height="50"></td>
                                <td class="actionSection">
                                    <a href="artistDelete.php?id=<?=$search['Artist_ID']?>">
                                        <div class="actionBtns"><i class="fas fa-trash"></i></div>
                                    </a> 
                                    <a href="artists.php?id=<?=$search['Artist_ID']?>">
                                        <div class="actionBtns" id="actionEdit"><i class="fas fa-edit"></i></div>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else echo "No Data Found"; 
                    }else{
                ?>
                               <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Artist Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=0; foreach ($artists as $artist) {?>
                            <tr>
                                <td><?=++$i?></td>
                                <td><?=$artist['Artist_Name']?></td>
                                <td><img src="../assets/artists/<?=$artist['Image']?>" width="50" height="50"></td>
                                <td class="actionSection">
                                    <a href="artistDelete.php?id=<?=$artist['Artist_ID']?>">
                                        <div class="actionBtns"><i class="fas fa-trash"></i></div>
                                    </a> 
                                    <a href="artists.php?id=<?=$artist['Artist_ID']?>">
                                        <div class="actionBtns" id="actionEdit"><i class="fas fa-edit"></i></div>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- for popup -->
<div class="popup<?php echo isset($_GET['id']) ? ' active' : ''; ?>">
    <div class="overlay"></div>
    <div class="content">
        <a href="artists.php"><div class="close-btn" id="close-btn" onclick="togglePopup(event)">&times;</div></a>
        <br>
        <div class="main-popup-content" >
            <h2>Artist Form</h2>
            <form  action="" id="registerForm" method="post" enctype="multipart/form-data">
                <?php if (isset($_GET['id'])) { 
                    $edit = $query->fetchData("artists", "Artist_ID",$_GET['id']);
                ?>
                    <input type="hidden" name="Artist_ID" value="<?=$_GET['id']?>">
                    
                <?php } ?>
                <label for="Artist_Name">Artist Name</label><br>
                <input type="text" name="Artist_Name" placeholder="Enter Your artist Name" value="<?= isset($_GET['id']) ? $edit[0]['Artist_Name'] : '' ?>" required><br>
                <label for="image">Image</label><br>
                <input type="file" name="image" id="image" ><br>
                <button name="addArtist">Submit</button>
            </form>
        </div>
    </div>
</div>
<script src="../js/adminPopup.js"></script>
<?php include('footer.php') ?>