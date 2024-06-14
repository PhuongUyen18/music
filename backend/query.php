<?php
include ('database.php');

class dbQuery extends Database
{

    function insertImg($imageFile, $loc)
    {
        $image = $imageFile;
        $tmp = $_FILES['image']['tmp_name'];
        $path = $loc . "/";
        move_uploaded_file($tmp, $path . $image);
    }

    function insertAudio($title, $loc)
    {
        $audio = $title . ".mp3"; // Use the title as the filename
        $tmp = $_FILES['audio']['tmp_name'];
        $path = $loc . '/';
        move_uploaded_file($tmp, $path . $audio);
    }


    function insert($table, $tableData, $loc)
    {
        $key = implode(",", array_keys($tableData));
        // Check if password field exists in $tableData
        if (array_key_exists('password', $tableData)) {
            // Hash the password using MD5
            $tableData['password'] = ($tableData['password']);
        }
        $values = implode("','", array_values($tableData));
        // If there is an image in the form
        if (isset($_FILES['image']) && $loc != '' && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $key .= ",image";
            $values .= "','" . $_FILES['image']['name'];
            // Call the insertImg function to handle image upload
            $this->insertImg($_FILES['image']['name'], $loc);
        }
        // If there is an audio file in the form
        if (isset($_FILES['audio']) && $_FILES['audio']['error'] == UPLOAD_ERR_OK) {
            // Pass the title from the form to the insertAudio function
            $this->insertAudio($_POST['Title'], $loc);
        }
        $sql = "INSERT INTO $table ($key) VALUES ('$values')";
        $result = $this->conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }



    function display($table)
    {
        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            echo "error occured";
        }
    }

    function displayJoin($sql)
    {
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    function delete($table, $id, $idVal)
    {
        $sql = "DELETE FROM $table WHERE $id=$idVal";
        $result = $this->conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function deleteImg($imageFile, $loc)
    {
        unlink($loc . "/" . $imageFile);
    }

    function fetchData($table, $id, $idVal)
    {
        $sql = "SELECT * FROM $table WHERE $id = $idVal";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }


    function edit($table, $id, $idVal, $tableData, $loc)
    {
        $keys = array_keys($tableData);
        // Check if password field is being updated
        if (isset($tableData['password'])) {
            $user = $this->fetchData($table, $id, $idVal);
            $prevPassword = $user[0]['Password'];

            // Compare previous password with new password
            if ($prevPassword !== $_POST['password']) {
                // Hash the new password with MD5
                $tableData['password'] = ($_POST['password']);
                echo "password changed";
            } else {
                echo "same";
            }
        }
        $values = array_values($tableData);
        $data = [];
        for ($i = 0; $i < count($keys); $i++) {
            $data[] = "{$keys[$i]}='{$values[$i]}' ";
        }
        $dataString = implode(',', $data); // it gives result -> name='$name' ,age='$age' ,address='$address'
        // If there is an image in the form
        if (isset($_FILES['image']) && $loc != '' && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $dataString .= ",Image='" . $_FILES['image']['name'] . "'";
            $user = $this->fetchData($table, $id, $idVal);
            $userImg = $user[0]['Image'];
            // Call the insertImg function to handle image upload
            $this->insertImg($_FILES['image']['name'], $loc);
            $this->deleteImg($userImg, $loc);
        }
        // If there is a title and Song_ID
        if (isset($_POST['Song_ID']) && !isset($_FILES['audio'])) {
            $user = $this->fetchData($table, $id, $idVal);
            $audio = $user[0]['Title'];
            // Check if the title is different from the previous title
            if ($_POST['Title'] !== $user[0]['Title']) {
                $filePath = '../assets/songs/' . $audio . '.mp3';
                $newFilePath = '../assets/songs/' . $_POST['Title'] . '.mp3';
                rename($filePath, $newFilePath);
            }
        }
        // If there is an audio file in the form
        if (isset($_FILES['audio']) && $loc != '' && $_FILES['audio']['error'] == UPLOAD_ERR_OK) {
            // Pass the title from the form to the insertAudio function
            $user = $this->fetchData($table, $id, $idVal);
            $audio = $user[0]['Title'] . '.mp3';
            $this->deleteImg($audio, $loc);
            $this->insertAudio($_POST['Title'], $loc);
        }
        $sql = "UPDATE $table SET $dataString  WHERE $id = $idVal";
        $result = $this->conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function search($searchData)
    {
        $sql = "SELECT Songs.*, Artists.Artist_Name,Artists.Image AS ArtistImage, Genres.Genre_Name, Albums.Title AS AlbumTitle 
                    FROM Songs
                    INNER JOIN Artists ON Songs.Artist_ID = Artists.Artist_ID
                    INNER JOIN Genres ON Songs.Genre_ID = Genres.Genre_ID
                    INNER JOIN Albums ON Songs.Album_ID = Albums.Album_ID
                    WHERE Songs.Title LIKE '%$searchData%'";
        $result = $this->conn->query($sql);
        if (!$result || $result->num_rows === 0) {
            echo "<div id='error-msg'> No Songs Found </div>";
        } else {
            // Process and display the search results
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    function searchf($table, $searchType, $value)
    {
        $sql = "SELECT * FROM $table WHERE $searchType LIKE '%$value%'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    function countRows($table)
    {
        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }


    function login($table, $email, $password)
    {
        $password = ($password);
        $sql = "SELECT * FROM $table WHERE email = '$email' AND password='$password'";
        $result = $this->conn->query($sql);
        $findData = $result->num_rows;
        if ($findData > 0) {
            $row = $result->fetch_assoc();
            session_start();
            $_SESSION['id'] = $row['User_ID'];
            $_SESSION['user'] = $row;
            $_SESSION['auth'] = TRUE;
            header("location:index.php");
        } else {
            // $_SESSION['error']="invalid email and password";
            echo '<div style="color:red; margin-top:10px;">invalid email or password</div>';
        }
    }

    function logout()
    {
        session_start();
        session_destroy();
        header("Location:login.php");
    }

    //for user authentication
    function sessionCheck()
    {
        session_start();
        if (!$_SESSION['auth']) {
            header("location:login.php");
        }
    }

    function likeSong($songId, $userId)
    {
        $sql = "INSERT INTO likedsongs (User_ID, Song_ID) VALUES ($userId,$songId)";
        $result = $this->conn->query($sql);
        if ($result) {
            echo "liked";
        }
    }

    function dislikeSong($songId, $userId)
    {
        $sql = "DELETE FROM likedsongs WHERE User_ID=$userId AND Song_ID = $songId";
        $result = $this->conn->query($sql);
        if ($result) {
            echo "disliked";
        }
    }

    function checkArtist($userId)
    {
        $sql = "SELECT * FROM artists WHERE User_ID=$userId ";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getArtistId($userId)
    {
        $sql = "SELECT Artist_ID FROM artists WHERE User_ID=$userId ";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['Artist_ID'];
        } else {
            return false;
        }
    }

    function checkLikeDislike($songId, $userId)
    {
        $sql = "SELECT * FROM likedsongs WHERE User_ID=$userId AND Song_ID = $songId";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function checkPlaylistSong($songId, $playlistId)
    {
        $sql = "SELECT * FROM playlist_songs WHERE Playlist_ID=$playlistId AND Song_ID = $songId";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function buyPremium($id)
    {
        $sql = "UPDATE users SET premium='1' WHERE User_ID=$id";
        $result = $this->conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
