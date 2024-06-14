<?php 
    include('../../backend/query.php');
    $query = new dbQuery;
    $query->sessionCheck();
    if ($query->checkArtist($_SESSION['id'])) {  
        $artistId = $query->getArtistId($_SESSION['id']);
        $sql = "SELECT * FROM albums WHERE Artist_ID = $artistId";
        $albums = $query->displayJoin($sql);
        if (!empty($albums)) { 
            foreach ($albums as $index => $album) {
                if ($index === count($albums) - 1) {

                    // Add the 'selected' attribute to the last option
                    echo "<option value='{$album['Album_ID']}' selected>{$album['Title']}</option>";
                } else {
                    // For other options
                    echo "<option value='{$album['Album_ID']}'>{$album['Title']}</option>";
                }
            }
        } else {
            // If no albums found
            echo "<option>No Albums Found</option>";
        }
    }
?>
