<?php
    include('../backend/query.php');
    $query = new dbQuery;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="content-part">
            <img src="assets/images/logo/loginLogo2.png">
        </div>

        <div class="login-part">
            <div class="login-icon">
                <iconify-icon icon="ri:music-fill" width="48" height="52"></iconify-icon>
            </div>
            <div class="login-msg">
                <h2>Welcome to MusicX</h2>
                <h4>Please enter your details</h4>
            </div>
            <div class="login-form">
                <form action="" method="post">
                    <label for="email">Email:</label><br>
                    <input type="email" name="email" id="email" required><br>
                    <label for="password">Password:</label><br>
                    <div>
                        <input type="password" name="password" id="password" required> <br>
                    </div>
                    <button>Login</button>
                    <?php
                    if (!empty($_POST)) {
                        $query->login("users", $_POST['email'], $_POST['password']);
                    }
                    ?>
                </form>
            </div>
            <div class="signup-part">
                <p>Don’t have an account?</p>
                <a href="register.php">Sign Up</a>
            </div>
        </div>
    </div>
</body>

</html>