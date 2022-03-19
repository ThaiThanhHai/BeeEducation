<!-- header section starts -->
<?php include("./includes/functions.php"); ?>

<?php if(isset($_GET['course_id']) || isset($_GET['introduce']) || isset($_GET['blog_id'])) { ?>
    <!-- header section starts -->
    <header>
        <div id="menu" class="fas fa-bars"></div>
        <a href="javascript:history.back()" class="previous"><i class="fas fa-angle-double-left"></i> Quay lại</a>
        <a href="#" class="logo"><i class="fab fa-forumbee"></i> Bee Education</a>
        <div class="personal"> 
            <div class="user">
                <?php if (isset($_SESSION['account_image']) && isset($_SESSION['account_name'])){ ?>
                    <img src="./Admin/img/accounts/<?php echo $_SESSION['account_image'] ?>">
                    <span><?php echo $_SESSION['account_name'] ?></span>
                <?php }else{
                    header("Location: login.php");
                    }?>
            </div>
            <div class="sub-menu">
                <ul>
                    <?php 
                    if($_SESSION['account_type'] == "admin"){
                        echo "<li><a href='user.php'>Trang cá nhân</a></li>
                              <li><a href='Admin'>Trang quản trị</a></li>
                              <li><a href='login.php'>Đăng xuất</a></li>";
                    }else{
                        echo "<li><a href='user.php'>Trang cá nhân</a></li>
                              <li><a href='login.php'>Đăng xuất</a></li>";
                    }
                    ?>
                </ul>
                

            </div>
        </div>
    </header>
    <!-- header section ends -->
<?php }else{ ?>
<header>
        <div id="menu" class="fas fa-bars"></div>

        <a href="#" class="logo"><i class="fab fa-forumbee"></i> Bee Education</a>

        <nav class="navbar">
           <ul>
                <li><a class="active" href="#home">Trang chủ</a></li>
                <li><a href="#about">Giới thiệu</a></li>
                <li><a href="#course">Khóa học</a></li>
                <li><a href="#blog">Bài viết</a></li>
                <li><a href="#review">Nhận xét</a></li>
                <li><a href="#contact">Liên hệ</a></li>
           </ul>
        </nav>

        <div class="personal"> 
            <div class="user">
                <img src="./Admin/img/accounts/<?php echo $_SESSION['account_image'] ?>">
                <span><?php echo $_SESSION['account_name'] ?></span>
            </div>
            <div class="sub-menu">
                <ul>
                    <?php 
                        if($_SESSION['account_type'] == "admin"){
                            echo "<li><a href='user.php'>Trang cá nhân</a></li>
                                <li><a href='Admin'>Trang quản trị</a></li>
                                <li><a href='login.php'>Đăng xuất</a></li>";
                        }else{
                            echo "<li><a href='user.php'>Trang cá nhân</a></li>
                                <li><a href='login.php'>Đăng xuất</a></li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </header>
<!-- header section ends -->

<?php }?>

