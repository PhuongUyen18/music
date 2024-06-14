<?php
include ('header.php');
$genres = $query->display("genres");
if (isset($_POST['addGenre'])) {
    unset($_POST['addGenre']);
    if (isset($_POST['Genre_ID'])) {
        if ($query->edit("genres", "Genre_ID", $_GET['id'], $_POST, "../assets/genres")) {
            header("location:genre.php");
        }
    } else {
        if ($query->insert("genres", $_POST, "../assets/genres")) {
            header("location:genre.php");
        }
    }
}
?>

<div class="container">
    <?php include ('adminSidebar.php') ?>
    <div class="contents">
        <div class="inner-content">
            <div class="content-header">
                <div class="content-header-leftPart">
                    <h2>Genres</h2>
                    <h4>Dashboard • Genres</h4>
                </div>
                <div class="content-header-rightPart">
                    <img src="../assets/adminImgs/songs.png" alt="">
                </div>
            </div>
            <div class="content-upper-body">
                <div class="searchBox">
                    <form action="" method="get">
                        <input type="text" name="search" value="<?php if (isset($_GET['search'])) {
                            echo $_GET['search'];
                        } ?>" placeholder="Enter something to search">
                        <button><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="addBtn" onclick="togglePopup(event)">Add genres</div>
            </div>
            <div class="content-lower-body">
                <?php
                if (isset($_GET['search'])) {
                    $searches = $query->searchf("genres", "Genre_Name", $_GET['search']);
                    if (!empty($searches)) {
                        ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0;
                                foreach ($searches as $search) { ?>
                                    <tr>
                                        <td>
                                            <?= ++$i ?>
                                        </td>
                                        <td>
                                            <?= $search['Genre_Name'] ?>
                                        </td>
                                        <td><img src="../assets/genres/<?= $search['Genre_Image'] ?>" width="50" height="50"></td>
                                        <td class="actionSection">
                                            <a href="genreDelete.php?id=<?= $search['Genre_ID'] ?>">
                                                <div class="actionBtns"><i class="fas fa-trash"></i></div>
                                            </a>
                                            <a href="genre.php?id=<?= $search['Genre_ID'] ?>">
                                                <div class="actionBtns" id="actionEdit"><i class="fas fa-edit"></i></div>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else
                        echo "No Data Found";
                } else {
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0;
                            foreach ($genres as $genre) { ?>
                                <tr>
                                    <td>
                                        <?= ++$i ?>
                                    </td>
                                    <td>
                                        <?= $genre['Genre_Name'] ?>
                                    </td>
                                    <td><img src="../assets/genres/<?= $genre['Genre_Image'] ?>" width="50" height="50"></td>
                                    <td class="actionSection">
                                        <a href="genreDelete.php?id=<?= $genre['Genre_ID'] ?>">
                                            <div class="actionBtns"><i class="fas fa-trash"></i></div>
                                        </a>
                                        <a href="genre.php?id=<?= $genre['Genre_ID'] ?>">
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
        <a href="genre.php">
            <div class="close-btn" id="close-btn" onclick="togglePopup(event)">&times;</div>
        </a>
        <br>
        <div class="main-popup-content">
            <h2>Genre Form</h2>
            <form action="" id="registerForm" method="post" enctype="multipart/form-data">
                <?php if (isset($_GET['id'])) {
                    $edit = $query->fetchData("genres", "Genre_ID", $_GET['id']);
                    ?>
                    <input type="hidden" name="Genre_ID" value="<?= $_GET['id'] ?>">

                <?php } ?>
                <label for="Genre_Name">Genre Name</label><br>
                <input type="text" name="Genre_Name" placeholder="Enter Your Genre Name"
                    value="<?= isset($_GET['id']) ? $edit[0]['Genre_Name'] : '' ?>"><br>
                <label for="image">Image</label><br>
                <input type="file" name="image" id="image"><br>
                <button name="addGenre">Submit</button>
            </form>
        </div>
    </div>
</div>
<script src="../js/adminPopup.js"></script>
<?php include ('footer.php') ?>