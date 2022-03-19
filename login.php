<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- google font cdn link -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- font anewesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- css file link -->
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <?php include ("./includes/functions.php"); ?>
    <div class="wrapper">
        <div class="container">
            <div class="sign-up-container">       
                <!-- Đang ký -->
                <form method="POST" id="Form-Register" enctype="multipart/form-data" onsubmit="return validateform()">
                    <h1>Đăng ký tạo tài khoản</h1>
                    <input type="text" name="account_name" required placeholder="Họ tên">
                    <input type="email" name="account_email" required placeholder="Email">
                    <input type="password" name="account_password" required placeholder="Mật khẩu">
                    <input type="password" name="account_password1" required placeholder="Nhập lại mật khẩu">
                    <input type="file" id="real-file" name="account_image" hidden="hidden">
                    <div class="image">
                        <button type="button" id="custom-button">Chọn ảnh</button>
                        <span id="custom-text">Không có tệp nào được chọn</span>
                    </div>
                    <button class="form-btn" name="signup">Đăng ký</button>
                </form>
            </div>
            <?php echo signup(); ?>

            <!-- Đăng nhập -->
            <div class="sign-in-container">
                <form method="POST" enctype="multipart/form-data" id="Form-Login">
                    <h1>Đăng nhập</h1>
                    <input type="email" name="account_email" required placeholder="Email">
                    <input type="password" name="account_password" required placeholder="Mật khẩu">
                    <button name="login" class="form-btn">Đăng nhập</button>
                </form>

                <?php echo login(); ?>
            </div>
            <div class="overlay-container">
                <div class="overley-left">
                    <h3>Bee Education</h3>
                    <p>Để tham gia các khóa học, vui lòng đăng nhập tài khoản</p>
                    <button id="SignIn" name="login" class="overlay_btn">Đăng nhập</button>
                </div>
                <div class="overlay-right">
                    <h3> Đăng ký tạo tài khoản</h3>
                    <p>Để tham gia các khóa học của BeeEducation</p>
                    <button id="SignUp" class="overlay_btn">Đăng ký</button>
                </div>
            </div>
            
        </div>
    </div>
    <!-- javascript -->
    <script src="./js/login.js"></script>
</body>
</html>