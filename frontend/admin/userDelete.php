<?php 
    include('header.php');
    $user = $query->fetchData("users", "User_ID",$_GET['id']);
    $userImg = $user[0]['Image'];
    if ($query->delete("users", "User_ID", $_GET['id'])) {
        $query->deleteImg($userImg,'../uploads');
        header("location:users.php");
    }
?>

