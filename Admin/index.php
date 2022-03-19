<?php session_start(); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Databoard</title>
    <link rel="stylesheet" href="./css/style.css">
    <!-- font anewesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- google font cdn link -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- navigation -->
        <?php include("./includes/navigation.php"); ?>
        <!-- header -->
        <?php include("./includes/header.php"); ?>
        <!-- content -->
        <?php include("./includes/content.php"); ?>
    </div>
    

    <!-- Javascript -->
    <script src="./js/main.js"></script>
</body>
</html>