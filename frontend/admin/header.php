<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c85c5e1d0c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/adminPanel.css">
    <link rel="stylesheet" href="../css/popup.css">
    <title>Admin Panel</title>
</head>
<?php 
    include('../../backend/query.php');
    $query = new dbQuery;
    $query->sessionCheck();
?>
<body>