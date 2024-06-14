<?php
include ('header.php');
$genres = $query->display("genres");
$artists = $query->display("artists");
$users = $query->display("users");
?>
<main class="container">
    <?php include ('adminSidebar.php') ?>
    <div class="contents">
        <div class="inner-content">
            <div class="content-header" style="background-color:#253662;">
                <h1>Welcome to Dashboard</h1>
            </div>
            <div class="status-info">
                <div class="status-info-members" id="users">
                    <div class="status-info-members-txt">
                        <h3>Users</h3>
                        <div class="count"><?= $query->countRows('users') ?></div>
                    </div>
                    <div class="status-info-members-icon">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="status-info-members" id="artists">
                    <div class="status-info-members-txt">
                        <h3>Artists</h3>
                        <div class="count"><?= $query->countRows('artists') ?></div>
                    </div>
                    <div class="status-info-members-icon">
                        <i class="fas fa-microphone-alt"></i>
                    </div>
                </div>
                <div class="status-info-members" id="songs">
                    <div class="status-info-members-txt">
                        <h3>Songs</h3>
                        <div class="count"><?= $query->countRows('songs') ?></div>
                    </div>
                    <div class="status-info-members-icon">
                        <i class="fas fa-music"></i>
                    </div>
                </div>
                <div class="status-info-members" id="genres">
                    <div class="status-info-members-txt">
                        <h3>Genres</h3>
                        <div class="count"><?= $query->countRows('genres') ?></div>
                    </div>
                    <div class="status-info-members-icon">
                        <i class="far fa-play-circle"></i>
                    </div>
                </div>
            </div>
            <a href="genre.php">
                <h1>Genre</h1>
            </a>
            <div class="home-content-box genre-box" id="genre">
                <?php foreach ($genres as $genre): ?>
                    <div class="box-content">
                        <div> <?php echo $genre['Genre_Name']; ?></div>
                        <img src="../assets/genres/<?= $genre['Genre_Image']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="artists.php">
                <h1 style="margin-top: 3vh;">Artist</h1>
            </a>
            <div class="home-content-box artist-box" id="genre">
                <?php foreach ($artists as $artist): ?>
                    <div class="box-content">
                        <img src="../assets/artists/<?= $artist['Image'] ?>" alt="">
                        <?php echo $artist['Artist_Name']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="users.php">
                <h1 style="margin-top: 3vh;">Users</h1>
            </a>
            <div class="home-content-box artist-box" id="genre">
                <?php foreach ($users as $user): ?>
                    <div class="box-content">
                        <img src="../uploads/<?= $user['Image'] ?>">
                        <?php echo $user['First_Name']; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let boxContents = document.querySelectorAll('.box-content');
        // Loop through each artist box
        boxContents.forEach(box => {
            // Find the image within the artist box
            const image = box.querySelector('img');
            // Create a canvas element
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            // Set the canvas size to match the image dimensions
            canvas.width = image.width;
            canvas.height = image.height;
            // Draw the image onto the canvas
            context.drawImage(image, 0, 0, image.width, image.height);
            // Get the image data from the canvas
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height).data;
            // Calculate the average RGB values
            let r = 0,
                g = 0,
                b = 0;
            for (let i = 0; i < imageData.length; i += 4) {
                r += imageData[i];
                g += imageData[i + 1];
                b += imageData[i + 2];
            }
            r = Math.floor(r / (imageData.length / 4));
            g = Math.floor(g / (imageData.length / 4));
            b = Math.floor(b / (imageData.length / 4));
            // Set the background color of the artist box
            box.style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
        });
    });

</script>
<?php include ('footer.php') ?>