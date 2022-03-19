<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang cá nhân</title>
    <!-- google font cdn link -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- font anewesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
     <!-- css file link -->
    <link rel="stylesheet" href="./css/user.css">
    
</head>
<body>
    <!-- header section starts -->
    <header class="header">
        <div class="user">
            <img src="./Admin/img/accounts/<?php echo $_SESSION['account_image'] ?>">
            <h3><?php echo $_SESSION['account_name'] ?></h3>
        </div>

        <nav class="navbar">
            <a href="user.php?info">Thông tin cá nhân</a>
            <a href="user.php?write_blog">Blogs chia sẻ</a>
            <a href="user.php?write_review">Nhận xét khóa học</a>
            <a href="login.php">Đăng xuất</a>
        </nav>
    </header>
    <!-- header section ends -->
    <div id="menu-btn" class="fas fa-bars"></div>
    <!-- previous -->
    <a href="index.php" id="previous"><i class="fas fa-angle-double-left"></i></a>
    <!-- theme toggler -->
    <div id="theme-toggler" class="fas fa-moon"></div>
    <?php include('./includes/functions.php'); ?>
    <?php if(isset($_GET['info'])){
            include("./includes/info.php");
        }else if(isset($_GET['write_blog'])){
            include("./includes/write_blog.php");
        }else if(isset($_GET['write_review'])){
            include("./includes/write_review.php");
        }
    ?>
    <script src="Admin/plugins/ckeditor/ckeditor.js"></script>
    <script src="Admin/plugins/ckfinder/ckfinder.js"></script>   
    <script src="./js/user.js"></script>
    
</body>
</html>