<?php
include('../../backend/query.php');
$query = new dbQuery;
$query->sessionCheck();


    if ($query->buyPremium($_SESSION['id'])) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error"));
    }

?>
