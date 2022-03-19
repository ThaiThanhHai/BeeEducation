<?php session_start(); ?>
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
    <!-- custom css file link -->
    <link rel="stylesheet" href="./css/style.css">
</head>
<body style="padding: 0 2%;">

    <!-- header section starts -->
    <?php include("./includes/header.php"); ?>
    <!-- header section ends -->

    <!-- section lesson starts -->
    <section class="lesson" id="lesson">
        
        <div class="lesson-container">
                <!-- Video chính -->
                <div class="main-video">
                    <?php view_first_lesson(); ?>
                    <p class="text">Liên hệ</p>
                    <div class="contact">
                        <ul>
                            <li>
                                <p>Facebook:</p>
                                <a href="">https://www.facebook.com/110118543843513</a>
                            </li>
                            <li>
                                <p>Youtube:</p>
                                <a href=""> https://www.youtube.com/channel/UC4B1...</a>
                            </li>
                            <li>
                                <p>Gmail:</p>
                                <a href="">Haib1809343@student.ctu.edu.vn</a>
                            </li>
                        </ul>
                    </div>
                    <div class="comments">
                        <div class="form-comment">
                            <img src="./Admin/img/accounts/<?php echo $_SESSION['account_image'] ?>">
                            <form action="" enctype="multipart/form-data" method="POST">
                                <input class="cmt-form" type="text" name="comment_content" required placeholder="Nhập bình luận">
                                <input type="text" class="lesson_id" name="lesson_link" style="opacity: 0;">
                                <button class="cmt-btn" name="add_comment">Bình luận</button>
                            </form>
                            
                        </div>
                        <!-- <div class="content">
                            <img src="./Admin/" alt="">
                            <p class="user-content">Đây là nội dung comment 1</p>
                        </div> -->
                        <?php echo add_comment(); ?>
                        <?php echo view_comment(); ?>

                    </div>
                </div>
                <!-- Danh sách video -->
                <div class="video-list">
                    <?php echo view_lesson(); ?>
                </div>
        </div>
    </section>
    <!-- section lesson ends -->

    <!-- footer section starts -->
    <?php include("./includes/footer.php") ?>
    <!-- footer section end -->

    <!-- jquery cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- custom js file link -->
    <script src="./js/main.js"></script>

</body>
</html>
