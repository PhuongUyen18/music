<?php
    include('../../backend/query.php');
    $query= new dbQuery;
    $query->sessionCheck();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST)) {
              if ($query->insert("albums",$_POST,'')) {
                echo "success";
              }       
        }
    }
?>