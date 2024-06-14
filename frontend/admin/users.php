<?php 
include('header.php');
$users = $query->display("users");
if (isset($_POST['adduser'])) {
    unset($_POST['adduser']);
    if (isset($_POST['User_ID'])) {
        if ($query->edit("users", "User_ID", $_GET['id'], $_POST,"../uploads")) {
            header("users.php");
        } 
    } else {
        if ($query->insert("users", $_POST, "../uploads")) {
            header("users.php");
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
                    <h2>Users</h2>
                    <h4>Dashboard • Users</h4>
                </div>
                <div class="content-header-rightPart">
                    <img src="../assets/adminImgs/users.png" style="width:125px; height:125px;">
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
                <div class="addBtn" onclick="togglePopup(event)">Add users</div>
            </div>
            <div class="content-lower-body">
            <?php 
                if (isset($_GET['search'])) {
                    $searches = $query->searchf("users","First_Name",$_GET['search']);
                    if (!empty($searches)){
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Type</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach ($searches as $search) {?>
                            <tr>
                                <td><?=++$i?></td>
                                <td><?=$search['First_Name']?></td>
                                <td><?=$search['Last_Name']?></td>
                                <td><?=$search['Email']?></td>
                                <td><?=$search['Password']?></td>
                                <td><?=$search['premium']==1 ? 'premium' : 'non-premium'?></td>
                                <td><img src="../uploads/<?=$search['Image']?>" width="50" height="50"></td>
                                <td class="actionSection">
                                    <a href="userDelete.php?id=<?=$search['User_ID']?>">
                                        <div class="actionBtns"><i class="fas fa-trash"></i></div>
                                    </a> 
                                    <a href="users.php?id=<?=$search['User_ID']?>">
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
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Type</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach ($users as $user) {?>
                            <tr>
                                <td><?=++$i?></td>
                                <td><?=$user['First_Name']?></td>
                                <td><?=$user['Last_Name']?></td>
                                <td><?=$user['Email']?></td>
                                <td><?=$user['Password']?></td>
                                <td><?=$user['premium']==1 ? 'premium' : 'non-premium'?></td>
                                <td><img src="../uploads/<?=$user['Image']?>" width="50" height="50"></td>
                                <td class="actionSection">
                                    <a href="userDelete.php?id=<?=$user['User_ID']?>">
                                        <div class="actionBtns"><i class="fas fa-trash"></i></div>
                                    </a> 
                                    <a href="users.php?id=<?=$user['User_ID']?>">
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
        <a href="users.php"><div class="close-btn" id="close-btn" onclick="togglePopup(event)">&times;</div></a>
        <br>
        <div class="main-popup-content" >
            <h2>User Form</h2>
            <form  action="" id="registerForm" method="post" enctype="multipart/form-data">
                <?php if (isset($_GET['id'])) { 
                    $edit = $query->fetchData("users", "User_ID",$_GET['id']);
                ?>
                    <input type="hidden" name="User_ID" value="<?=$_GET['id']?>">
                    
                <?php } ?>
                <label for="First_Name">First Name</label><br>
                <input type="text" name="First_Name" placeholder="Enter Your First Name" value="<?= isset($_GET['id']) ? $edit[0]['First_Name'] : '' ?>"><br>
                <label for="Last_Name">Last Name</label><br>
                <input type="text" name="Last_Name" placeholder="Enter Your user Name" value="<?= isset($_GET['id']) ? $edit[0]['Last_Name'] : '' ?>"><br>
                <label for="email">Email</label><br>
                <input type="email" name="Email" placeholder="Enter Your Email" value="<?= isset($_GET['id']) ? $edit[0]['Email'] : '' ?>"><br>
                <label for="password">Password</label><br>
                <input type="password" name="Password" placeholder="Enter Your Password" value="<?= isset($_GET['id']) ? $edit[0]['Password'] : '' ?>"><br>
                <label for="status">Status</label><br>
                <select name="premium">
                    <option value="0" <?= isset($_GET['id']) && $edit[0]['premium']==0 ? 'selected' : '' ?>>Non-Premium</option>
                    <option value="1" <?= isset($_GET['id']) && $edit[0]['premium']==1 ? 'selected' : '' ?>>Premium</option>
                </select>
                <label for="image">Image</label><br>
                <input type="file" name="image" id="image"><br>
                <button name="adduser">Submit</button>
            </form>
        </div>
    </div>
</div>
<script src="../js/adminPopup.js"></script>
<?php include('footer.php') ?>