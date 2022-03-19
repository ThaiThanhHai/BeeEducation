<?php 
    session_start(); 
    if(!isset($_SESSION['account_id'])){
        header("Location: login.php");
        die;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education</title>
    <!-- google font cdn link -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- font anewesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- css file link -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- owl  carousel js cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
</head>
<body>
    <?php 
        include("./includes/header.php"); 
        include("./includes/home.php");
        include("./includes/about.php");
        include("./includes/course.php");
        include("./includes/blog.php");
        include("./includes/review.php");
        include("./includes/contact.php");
        // include("./includes/footer.php");
    ?>

    <!-- jquery cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- custom js file link -->
    <script src="./js/main.js"></script>
    <!-- owl  carousel js cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</body>
</html>