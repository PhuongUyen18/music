<?php
    include('../../backend/query.php');
    $query= new dbQuery;
    $query->sessionCheck();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST)) {
           if ($query->edit("users", "User_ID", $_SESSION['id'], $_POST,'../uploads')) {
                echo json_encode(array("status" => "success"));
           } else{
                echo json_encode(array("status" => "error"));
           }
        }
    }
?>