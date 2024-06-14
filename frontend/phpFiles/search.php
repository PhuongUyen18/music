<?php 
    include('../../backend/query.php');
    $query= new dbQuery;
    $query->sessionCheck();
    $searchDatas = $query->search($_GET['search']);
    $i=0;
    if (!empty($searchDatas)) :
        foreach ($searchDatas as $song) :
            // this is a dynamic element so i added an onclick function again so the event can be delegated
            $likeDislikeStyle = $query->checkLikeDislike($song['Song_ID'], $_SESSION['id']) ? "color: #284edb;" : "color:white";
?>

            <tr onclick='songFunction(this)'> 
            <td><?=++$i?></td>
            <td><?=$song['Title']?></td>
            <td><?=$song['Artist_Name']?></td>
            <td><?=$song['Genre_Name']?></td>
            <td><?=$song['AlbumTitle']?></td>
            <td><img src='assets/artists/<?=$song['ArtistImage']?>' alt='image' style='width:50px; height:50px;'></td>
            <td onclick='likeDislikeFn(event)' class='likeDislike'>
            <span style='display:none;'><?=$song['Song_ID']?></span>
            <i class='fa-solid fa-heart' style='<?=$likeDislikeStyle?>'></i>
            </td>
            <td onclick="togglePopup(event)">
                <span style="display:none;"><?=$song['Song_ID']?></span>
                <i class='fa-regular fa-square-plus'></i>
            </td>
          </tr>

<?php
        endforeach;
    endif;
?>

