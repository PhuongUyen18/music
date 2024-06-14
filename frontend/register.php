<?php
include ('../backend/query.php');
$query = new dbQuery;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="js/validate.js" defer></script>
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="content-part">
            <img src="assets/images/logo/register.png">
        </div>

        <div class="register-part">
            <div class="register-icon">
                <iconify-icon icon="ri:music-fill" width="48" height="52"></iconify-icon>
            </div>
            <div class="register-msg">
                <h2>Create an Account</h2>
                <h4>Please enter your details</h4>
            </div>
            <div class="register-form">
                <form id="myform" action="" method="post" enctype="multipart/form-data">
                    <div class="formMember">
                        <input type="text" name="First_Name" id="First_Name" placeholder="First Name"><br>
                        <a style="color: red;"></a>
                    </div>
                    <div class="formMember">
                        <input type="text" name="Last_Name" id="Last_Name" placeholder="Last Name">
                        <a style="color: red;"></a>
                    </div>
                    <div class="formMember">
                        <input type="email" name="email" id="email" placeholder="Email">
                        <a style="color: red;"></a>
                    </div>
                    <div class="formMember">
                        <input type="password" name="password" id="password" placeholder="Password">
                        <a style="color: red;"></a>
                    </div>
                    <div class="formMember">
                        <input type="password" name="reenter_password" id="reenter_password"
                            placeholder="Re-enter Password">
                        <a style="color: red;"></a>
                    </div>
                    <label for="image">
                        <div class="formMember">
                            <div id="imgUpload" style="display: flex; justify-content:space-between;">
                                Choose Image
                                <div style="height:4vh; display:grid; place-items:center;">
                                    <iconify-icon icon="solar:gallery-bold" width="20" height="20"></iconify-icon>
                                </div>
                            </div>
                            <input style="display: none;" type="file" name="image" id="image">
                            <a style="color: red; "></a>
                        </div>
                    </label>
                    <button>Sign Up</button>
                </form>
            </div>
            <?php
            if (!empty($_POST)) {
                unset($_POST['reenter_password']);
                if ($query->insert("users", $_POST, 'uploads')) {
                    echo "<div style='font-weight:bold; margin-top:1vh;'>Registered Successfully </div>";
                }
            }
            ?>
            <div class="signup-part">
                <p>Already have an account?</p>
                <a href="login.php">Sign In</a>
            </div>
        </div>
    </div>
</body>

</html>