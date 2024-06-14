<?php
    include('../../backend/query.php');
    $query= new dbQuery;
    $query->sessionCheck();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST)) {
            if ($query->insert("songs",$_POST,'../assets/songs')) {
                echo json_encode(array("status" => "success"));
            } else {
                echo json_encode(array("status" => "error"));
            }
        }
    }
?>