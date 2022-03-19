<?php
    include("./Admin/includes/duration.php");
    //==================Trang chu=======================

    //Liet ke khoa hoc
    function view_course(){
        include("includes/database.php");

        $get_course=$con->prepare("SELECT * FROM courses");
        $get_course->setFetchMode(PDO:: FETCH_ASSOC);
        $get_course->execute();
        while($row=$get_course->fetch()){
            echo "<div class='box'> 
                    <a href='curriculum.php?course_id=".$row['course_id']."'>
                        <img src='./Admin/img/courses/".$row['course_image']."'>
                        <p class='title'>".$row['course_name']."</p>
                    </a>
                </div>";
        }
    }

    // ==================================================

    //=================Chương trình giảng dạy============

    //Liệt kê tên khóa học và mô tả bài giảng
    function view_course_name() {
        include("includes/database.php");

        if(isset($_GET['course_id'])){
            $course_id = $_GET['course_id'];
        }

        $get_course=$con->prepare("SELECT * FROM courses WHERE course_id = '$course_id'");
        $get_course->setFetchMode(PDO:: FETCH_ASSOC);
        $get_course->execute();
        $row_course=$get_course->fetch();

        echo "<h1 class='courseName'>".$row_course['course_name']."</h1>";
        echo "<div class='textContent'><p>".$row_course['course_desrcibe']."</p></div>";

    }
    
    //Liệt kê chương trình giảng dạy
    function view_curriculum(){
        include("includes/database.php");
        
        if(isset($_GET['course_id'])){
            $course_id = $_GET['course_id'];
        }
        
        $get_chapter=$con->prepare("select * from chapters where course_id = '$course_id'");
        $get_chapter->setFetchMode(PDO:: FETCH_ASSOC);
        $get_chapter->execute();
        
        
        while($row_chapter=$get_chapter->fetch()){
            $chapter_id = $row_chapter['chapter_id'];
            $get_lesson=$con->prepare("select * from lessons where chapter_id = '$chapter_id'");
            $get_lesson->setFetchMode(PDO:: FETCH_ASSOC);
            $get_lesson->execute();
            
            
            
            echo "<div class='Panel'>
                    <div class='panelHeading'>
                        <h5>".$row_chapter['chapter_name']."</h5>
                    </div>";
                while($row_lesson=$get_lesson->fetch()){
                    $video_time = chang_time($row_lesson['lesson_duration']);
                    echo " <div class='panelBody'>
                                <div class='lessonItem'>
                                    <div class='lessonName'>".$row_lesson['lesson_title']."</div>
                                    <div class='lessonTime'>$video_time</div>
                                </div>                          
                            </div>";
                }
                   
            echo "</div>";
        }
    }

    //Hiển thị mục đích khóa học
    function select_purpose(){
        include("includes/database.php");
        
        if(isset($_GET['course_id'])){
            $course_id = $_GET['course_id'];
        }

        $get_purpose=$con->prepare("SELECT * FROM purpose WHERE course_id = '$course_id'");
        $get_purpose->setFetchMode(PDO:: FETCH_ASSOC);
        $get_purpose->execute();

        while($row_purpose=$get_purpose->fetch()){

            echo "<li>
                    <i class='fas fa-check'></i>
                    <span>".$row_purpose['purpose_content']."</span>
                </li>";
        }
    }

    //Đếm số chủ đề
    function count_chapter(){
        include("includes/database.php");

        if(isset($_GET['course_id'])){
            $course_id = $_GET['course_id'];
        }

        $get_chapter=$con->prepare("SELECT COUNT(*) AS count FROM chapters WHERE course_id='$course_id'");
        $get_chapter->setFetchMode(PDO:: FETCH_ASSOC);
        $get_chapter->execute();
        $row_chapter=$get_chapter->fetch();
        // print_r($row_chapter);
        echo $row_chapter['count'];
    }

    //Đếm số bài giảng
    function count_lesson(){
        include("includes/database.php");

        if(isset($_GET['course_id'])){
            $course_id = $_GET['course_id'];
        }

        $get_chapter=$con->prepare("SELECT * FROM chapters WHERE course_id='$course_id'");
        $get_chapter->setFetchMode(PDO:: FETCH_ASSOC);
        $get_chapter->execute();
        $sum = 0;
        
        while($row_chapter=$get_chapter->fetch()){
            $chapter_id = $row_chapter['chapter_id'];
            $get_lesson=$con->prepare("SELECT COUNT(*) AS count FROM lessons WHERE chapter_id='$chapter_id'");
            $get_lesson->setFetchMode(PDO:: FETCH_ASSOC);
            $get_lesson->execute();
            $row_lesson=$get_lesson->fetch();
            $sum = $sum + $row_lesson['count'];
            
        }
        echo $sum;
    }


    function count_time(){
        include("includes/database.php");

        if(isset($_GET['course_id'])){
            $course_id = $_GET['course_id'];
        }
        
        $get_chapter=$con->prepare("SELECT * FROM chapters WHERE course_id = '$course_id'");
        $get_chapter->setFetchMode(PDO:: FETCH_ASSOC);
        $get_chapter->execute();
        
        $time = 0;
        while($row_chapter=$get_chapter->fetch()){
            $chapter_id = $row_chapter['chapter_id'];
            $get_lesson=$con->prepare("SELECT * FROM lessons WHERE chapter_id = '$chapter_id'");
            $get_lesson->setFetchMode(PDO:: FETCH_ASSOC);
            $get_lesson->execute();

            while($row_lesson=$get_lesson->fetch()){
                $time = $time + $row_lesson['lesson_duration'];
            }
        }
        $hour = substr(chang_time($time), 0, 2);
        $minute = substr(chang_time($time), 3, 2);

        echo $hour . " giờ " . $minute . " phút";
    }

    /**==================Bài Giảng====================== */
    function view_first_lesson(){
        include("includes/database.php");

        if(isset($_GET['course_id'])){
            $course_id = $_GET['course_id'];
        }

        $get_chapter=$con->prepare("SELECT * FROM chapters WHERE course_id='$course_id'");
        $get_chapter->setFetchMode(PDO:: FETCH_ASSOC);
        $get_chapter->execute();
        $row_chapter=$get_chapter->fetch();

        $chapter_id = $row_chapter['chapter_id'];
        $get_lesson=$con->prepare("SELECT * FROM lessons WHERE chapter_id = '$chapter_id'");
        $get_lesson->setFetchMode(PDO:: FETCH_ASSOC);
        $get_lesson->execute();
        $row_lesson=$get_lesson->fetch();


        echo "<div class='video'>
                    <iframe width='560' height='315' src='".$row_lesson['lesson_link']."' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen class='main'></iframe>
                </div>
                <h3 class='title'>".$row_lesson['lesson_title']."</h3>
                <p class='text'>".$row_lesson['lesson_desrcibe']."</p><br>";
    }

    function view_lesson(){
        include("includes/database.php");

        if(isset($_GET['course_id'])){
            $course_id = $_GET['course_id'];
        }
        
        $get_chapter=$con->prepare("SELECT * FROM chapters WHERE course_id = '$course_id'");
        $get_chapter->setFetchMode(PDO:: FETCH_ASSOC);
        $get_chapter->execute();
        
        
        while($row_chapter=$get_chapter->fetch()){
            $chapter_id = $row_chapter['chapter_id'];
            $get_lesson=$con->prepare("SELECT * FROM lessons WHERE chapter_id = '$chapter_id'");
            $get_lesson->setFetchMode(PDO:: FETCH_ASSOC);
            $get_lesson->execute();            
           
            while($row_lesson=$get_lesson->fetch()){
                $video_time = chang_time($row_lesson['lesson_duration']);
                echo "
                      <div class='vid'>
                        <a href='".$row_lesson['lesson_link']."' class='video-links'>
                            <i class='far fa-play-circle icon'></i>
                            <h3 class='title'><span class='name'>".$row_lesson['lesson_title']."</span><p>".$video_time."</p></h3>
                        </a>
                      </div>
                    ";

            }
                   
        }
    }

//     <div class='vid'>
//     <a href='".$row_lesson['lesson_link']."' class='video-links'>
//         <i class='far fa-play-circle icon'></i>
//         <h3 class='title'><span class='name'>".$row_lesson['lesson_title']."</span><p>".$video_time."</p></h3>
//     </a>
//   </div>";

    function add_comment(){
        include("includes/database.php");

        if(isset($_POST['add_comment'])){
            if (isset($_SESSION['account_image'])){
                $account_image = $_SESSION['account_image'];
            }
            if (isset($_POST['lesson_link'])){
                $lesson_link = $_POST['lesson_link'];
            }
    
            if (isset($_POST['comment_content'])){
                $comment_content = $_POST['comment_content'];
            }
    
            $get_lesson=$con->prepare("SELECT * FROM lessons WHERE lesson_link='$lesson_link'");
            $get_lesson->setFetchMode(PDO:: FETCH_ASSOC);
            $get_lesson->execute();
            $row_less=$get_lesson->fetch();
            $lesson_id = $row_less['lesson_id'];
    
            $get_account=$con->prepare("SELECT * FROM accounts WHERE account_image='$account_image'");
            $get_account->setFetchMode(PDO:: FETCH_ASSOC);
            $get_account->execute();
            $row_acc=$get_account->fetch();
            $account_id = $row_acc['account_id'];
            
            $add_comment = $con->prepare("INSERT INTO comments(comment_content,account_id,lesson_id) VALUES ('$comment_content', '$account_id', '$lesson_id')");
            if(!$add_comment->execute()) {
                echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại sau!')</script>";
            }  
        }
    }

    function view_comment(){
        include("includes/database.php");
        
        $get_comment=$con->prepare("SELECT * FROM comments");
        $get_comment->setFetchMode(PDO:: FETCH_ASSOC);
        $get_comment->execute();
        while($row_cmt=$get_comment->fetch()){
            $acc_id=$row_cmt['account_id'];
            $get_acc=$con->prepare("SELECT * FROM accounts WHERE account_id='$acc_id'");
            $get_acc->setFetchMode(PDO:: FETCH_ASSOC);
            $get_acc->execute();
            $row_acc=$get_acc->fetch();
            $account_image = $row_acc['account_image'];
            echo "<div class='content'>
                    <img src='./Admin/img/accounts/".$account_image."'>
                    <p class='user-content'>".$row_cmt['comment_content']."</p>
                </div>";
        }
        
    }

    /**================================================= */


    /**===================Giới thiệu==================== */
    function view_intro(){
        include("includes/database.php");

        $get_intro = $con->prepare("SELECT * FROM intro");
        $get_intro->setFetchMode(PDO:: FETCH_ASSOC);
        $get_intro->execute();

        $row_intro = $get_intro->fetch();

        echo $row_intro['intro_content'];
    }

    /**================================================= */

    /**==================Trang cá nhân================== */
    //Chỉnh sửa thông tin người dùng
    function edit_account(){
        include("includes/database.php");

        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_SESSION['account_id'])){
                $account_id = $_SESSION['account_id'];
                $account_name = trim($_POST['account_name']);
                $account_email = trim($_POST['account_email']);
                $account_password = hash('sha1', trim($_POST['account_password']));
    
                $image = $_FILES['account_image'];
                $allow_size = 10; //cho phép tải ảnh nhỏ hơn 10MB
                $account_image = $image['name'];//lấy tên ảnh khóa học
                if(!empty($account_image)){
                    //Đổi tên file
                    $account_image = explode('.', $account_image); //cắt sau dấu chấm và lưu vào mảng
                    $ext = end($account_image); //lấy phần tử cuối của mảng
                    $new_account_image = uniqid() . '.' . $ext; //đặt tên mới

                    //Kiểm tra định dạng file
                    $allow_ext = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
                    if(!in_array($ext, $allow_ext)){//Không thỏa điều kiện định dạng
                        echo "<script>alert('Tệp mở rộng phải là đuôi png, jpg, jpeg, gif, webp!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/user.php?info';</script>";
                    }else{
                        $size = $image['size']/1024/1024; //byte => megabyte
                        if($size > $allow_size){ //Ko thỏa điều kiện size
                            echo "<script>alert('Kích thước ảnh phải nhỏ hơn 2MB!')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/user.php?info';</script>";
                        }else{
                            $upload = move_uploaded_file($image['tmp_name'], 'Admin/img/accounts/' .$new_account_image);
                            if(!$upload){ 
                                echo "<script>alert('Không thể tải ảnh lên vào thời điểm này. Vui lòng thử lại sau!')</script>";
                                echo "<script>location.href='http://localhost/BeeEducation/user.php?info';</script>";
                            }else{    
                                $edit_account = $con->prepare("UPDATE accounts SET account_name='$account_name', account_email='$account_email', account_password='$account_password', account_image='$new_account_image' WHERE account_id='$account_id'");
                                if($edit_account->execute()) {
                                    $_SESSION['account_name'] = $account_name;
                                    $_SESSION['account_email'] = $account_email;
                                    $_SESSION['account_password'] = $account_password;
                                    $_SESSION['account_image'] = $new_account_image;
                                    echo "<script>alert('Chỉnh sửa tài khoản thành công')</script>";
                                    echo "<script>location.href='http://localhost/BeeEducation/user.php?info';</script>";
                                    
                                }else {
                                    echo "<script>alert('Chỉnh sửa thất bại. Vui lòng thử lại sau!')</script>";
                                    echo "<script>location.href='http://localhost/BeeEducation/user.php?info';</script>";
                                }   
                            }
                        }
                    }
                }else{ 
                    $edit_account = $con->prepare("UPDATE accounts SET account_name='$account_name', account_email='$account_email', account_password='$account_password' WHERE account_id='$account_id'");
                    if($edit_account->execute()) {
                        $_SESSION['account_name'] = $account_name;
                        $_SESSION['account_email'] = $account_email;
                        $_SESSION['account_password'] = $account_password;
                        $_SESSION['account_image'] = $new_account_image;
                        echo "<script>alert('Chỉnh sửa tài khoản thành công')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/user.php?info';</script>";
                        
                    }else {
                        echo "<script>alert('Chỉnh sửa thất bại. Vui lòng thử lại sau!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/user.php?info';</script>";
                    }  
                }                
            }
        }
        
    }

    //Viết blogs
    function add_blog(){
        include("includes/database.php");
        $account_id = $_SESSION['account_id'];
        $account_type = $_SESSION['account_type'];
        // print($account_type);
        // print($account_id);
        //Kiểm tra POST có tồn tại
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //----Kiểm tra tên chủ đề
            if(isset($_POST['add_blog'])){
                $blog_content =  $_POST['content'];
                $blog_title = $_POST['blog-title'];
                if(empty($blog_title)){
                    echo "<script>alert('Vui lòng nhập tiêu đề bài viết!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/user.php?write_blog';</script>";
                }
                if(empty($blog_content)){
                    echo "<script>alert('Vui lòng nhập nội dung bài viết!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/user.php?write_blog';</script>";
                }
            }

            //----Kiểm tra ảnh tiêu đề
            $image = $_FILES['blog-imgae'];
            $allow_size = 10; //cho phép tải ảnh nhỏ hơn 10MB
            $blog_image = $image['name']; //lấy tên ảnh khóa học

            if(empty($blog_image)){//nếu tên rỗng, thoát và yêu cầu nhập lại
                echo "<script>alert('Vui lòng chọn ảnh tiêu đề bài viết!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/user.php?write_blog';</script>";
            }else{
                //Đổi tên file
                $blog_image = explode('.', $blog_image); //cắt sau dấu chấm và lưu vào mảng
                $ext = end($blog_image); //lấy phần tử cuối của mảng
                $new_blog_image = uniqid() . '.' . $ext; //đặt tên mới

                //Kiểm tra định dạng file
                $allow_ext = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
                if(!in_array($ext, $allow_ext)){//Không thỏa điều kiện định dạng
                    echo "<script>alert('Tệp mở rộng phải là đuôi png, jpg, jpeg, gif, webp!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/user.php?write_blog';</script>";
                }else{
                    $size = $image['size']/1024/1024; //byte => megabyte
                    if($size > $allow_size){ //Ko thỏa điều kiện size
                        echo "<script>alert('Kích thước ảnh phải nhỏ hơn 2MB!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/user.php?write_blog';</script>";
                    }else{
                        $upload = move_uploaded_file($image['tmp_name'], 'Admin/img/blogs/image_title/' .$new_blog_image);
                        if(!$upload){ 
                            echo "<script>alert('Không thể tải ảnh lên vào thời điểm này. Vui lòng thử lại sau!')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/user.php?write_blog';</script>";
                        }else{
                            if($account_type=='admin'){
                                $add_blog = $con->prepare("INSERT INTO blogs(blog_title,blog_image,blog_content,blog_status, account_id) VALUES ('$blog_title','$new_blog_image','$blog_content',1,'$account_id')");
                            }else{
                                $add_blog = $con->prepare("INSERT INTO blogs(blog_title,blog_image,blog_content,blog_status, account_id) VALUES ('$blog_title','$new_blog_image','$blog_content',0,'$account_id')");
                            }
                            if($add_blog->execute()) {
                                echo "<script>alert('Đã thêm thành công')</script>";
                                echo "<script>location.href='http://localhost/BeeEducation/user.php?write_blog';</script>";
                            }else {
                                echo "<script>alert('Thêm thất bại. Vui lòng thử lại sau!')</script>";
                                echo "<script>location.href='http://localhost/BeeEducation/user.php?write_blog';</script>";
                            }
                        }
                    }
                }
            }
        }
    }

    //Hiển thị tiêu đề & ảnh tiêu đề blog
    function view_title_blog(){
        include("includes/database.php");

        $get_blog = $con->prepare("SELECT * FROM blogs WHERE blog_status=1");
        $get_blog->setFetchMode(PDO:: FETCH_ASSOC);
        $get_blog->execute();

        while($row_blog = $get_blog->fetch()){
            echo "<div class='box'>
                        <a href='display_blog.php?blog_id=".$row_blog['blog_id']."'>
                            <img src='./Admin/img/blogs/image_title/".$row_blog['blog_image']."'>
                            <p class='title'>".$row_blog['blog_title']."</p>
                        </a>
                  </div>";
        }
    }

    //Hiển thị tiêu đề và nội dung blog
    function view_content_blog(){
        include("includes/database.php");
        $blog_id = $_GET['blog_id'];
        $get_blog = $con->prepare("SELECT * FROM blogs WHERE blog_id=$blog_id");
        $get_blog->setFetchMode(PDO:: FETCH_ASSOC);
        $get_blog->execute();

        $row_blog = $get_blog->fetch();
        echo "<h1>".$row_blog['blog_title']."</h1>";
        echo $row_blog['blog_content'];
    }

    //Viết review khóa học
    function add_review(){
        //Kết nối csdl
        include("includes/database.php");
        //Kiểm tra POST có tồn tại
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //----Kiểm tra tên chủ đề
            if(isset($_POST['add_reivew'])){
                $review_content = trim($_POST['review-content']);
                $account_id = 1;
                if(empty($review_content)){
                    echo "<script>alert('Vui lòng nhập nội dung yêu cầu!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/user.php?write_review';</script>";
                }
            }       
            //Kiểm tra chủ đề có tồn tại trong csdl        
            $add_review = $con->prepare("INSERT INTO reviews(review_content,account_id) VALUES ('$review_content', '$account_id')");
            if($add_review->execute()) {
                echo "<script>alert('Đã thêm thành công')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/user.php?write_review';</script>";    
            }else {
                echo "<script>alert('Thêm thất bại. Vui lòng thử lại sau!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/user.php?write_review';</script>";
            }
        }
    }

    function view_review(){
        include("includes/database.php");

        $get_review = $con->prepare("SELECT * FROM reviews");
        $get_review->setFetchMode(PDO:: FETCH_ASSOC);
        $get_review->execute();
      

        while($row_review = $get_review->fetch()){
            $get_account = $con->prepare("SELECT * FROM accounts WHERE account_id = 1");
            $get_account->setFetchMode(PDO:: FETCH_ASSOC);
            $get_account->execute();
            $row_account = $get_account->fetch();

            echo "<div class='feel'>
                        <i class='fas fa-quote-right icon'></i>
                        <div class='user'>
                            <img src='./Admin/img/accounts/".$row_account['account_image']."'>
                            <div class='user-info'>
                                <h3>".$row_account['account_name']."</h3>
                                <div class='stars'>
                                    <i class='fas fa-star'></i>
                                    <i class='fas fa-star'></i>
                                    <i class='fas fa-star'></i>
                                    <i class='fas fa-star'></i>
                                    <i class='far fa-star'></i>
                                </div>
                            </div>
                        </div>
                        <p class='text'>".$row_review['review_content']."</p>
                    </div>";
            
        }
    }
    /**================================================== */





    /**==============ĐĂNG NHẬP/ĐĂNG KÝ=================== */
    function signup(){
        //Kết nối csdl
        include("includes/database.php");
        //Kiểm tra POST có tồn tại
        if($_SERVER['REQUEST_METHOD']=='POST'){
            
            if(isset($_POST['signup'])){
                $account_name = trim($_POST['account_name']);
                $account_email = trim($_POST['account_email']);
                $account_password = hash('sha1', trim($_POST['account_password']));
                $account_type = 'user';
                
                $image = $_FILES['account_image'];
                $allow_size = 10; //cho phép tải ảnh nhỏ hơn 10MB
                $account_image = $image['name'];//lấy tên ảnh khóa học
                if(!empty($account_image)){
                    //Đổi tên file
                    $account_image = explode('.', $account_image); //cắt sau dấu chấm và lưu vào mảng
                    $ext = end($account_image); //lấy phần tử cuối của mảng
                    $new_account_image = uniqid() . '.' . $ext; //đặt tên mới

                    //Kiểm tra định dạng file
                    $allow_ext = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
                    if(!in_array($ext, $allow_ext)){//Không thỏa điều kiện định dạng
                        echo "<script>alert('Tệp mở rộng phải là đuôi png, jpg, jpeg, gif, webp!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/login.php';</script>";
                    }else{
                        $size = $image['size']/1024/1024; //byte => megabyte
                        if($size > $allow_size){ //Ko thỏa điều kiện size
                            echo "<script>alert('Kích thước ảnh phải nhỏ hơn 2MB!')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/login.php';</script>";
                        }else{
                            $upload = move_uploaded_file($image['tmp_name'], 'Admin/img/accounts/' .$new_account_image);
                            if(!$upload){ 
                                echo "<script>alert('Không thể tải ảnh lên vào thời điểm này. Vui lòng thử lại sau!')</script>";
                                echo "<script>location.href='http://localhost/BeeEducation/login.php';</script>";
                            }else{
                                //Kiểm tra tài khoản có tồn tại trong csdl
                                $check = $con->prepare("SELECT * FROM accounts WHERE account_name='$account_name' AND account_email='$account_email'");
                                $check->setFetchMode(PDO:: FETCH_ASSOC);
                                $check->execute();
                                $count = $check->rowCount(); 
                                if($count > 0){ //tài khoản tồn tại trong csdl
                                    echo "<script>alert('Tài khoản đã tồn tại')</script>";
                                    echo "<script>location.href='http://localhost/BeeEducation/login.php';</script>";       
                                }else{
                                    $add_account = $con->prepare("INSERT INTO accounts(account_name,account_email,account_password,account_type,account_image) VALUES ('$account_name','$account_email', '$account_password','$account_type','$new_account_image')");
                                    if($add_account->execute()) {
                                        echo "<script>alert('Đã tạo tài khoản thành công')</script>";
                                        echo "<script>location.href='http://localhost/BeeEducation/login.php';</script>";
                                        
                                    }else {
                                        echo "<script>alert('Thêm thất bại. Vui lòng thử lại sau!')</script>";
                                        echo "<script>location.href='http://localhost/BeeEducation/login.php';</script>";
                                    }
                                }
                            }
                        }
                    }
                }else{
                    $account_image = "unnamed.png";
                    //Kiểm tra tài khoản có tồn tại trong csdl
                    $check = $con->prepare("SELECT * FROM accounts WHERE account_name='$account_name' AND account_email='$account_email'");
                    $check->setFetchMode(PDO:: FETCH_ASSOC);
                    $check->execute();
                    $count = $check->rowCount(); 
                    if($count > 0){ //tài khoản tồn tại trong csdl
                        echo "<script>alert('Tài khoản này đã tồn tại')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/login.php';</script>";       
                    }else{
                        $add_account = $con->prepare("INSERT INTO accounts(account_name,account_email,account_password,account_type,account_image) VALUES ('$account_name','$account_email', '$account_password','$account_type','$account_image')");
                        if($add_account->execute()) {
                            echo "<script>alert('Đã tạo tài khoản thành công')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/login.php';</script>";
                            
                        }else {
                            echo "<script>alert('Thêm thất bại. Vui lòng thử lại sau!')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/login.php';</script>";
                        }
                    }  
                 }                
            }
        }
    }


    function login(){
        //Kết nối csdl
        include("includes/database.php");
    
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST['login'])){
                $account_email = $_POST['account_email'];
                $account_password = hash('sha1', $_POST['account_password']);
    
                
                $check = $con->prepare("SELECT * FROM accounts WHERE account_email= '$account_email' AND account_password='$account_password' LIMIT 1");
                $check->setFetchMode(PDO:: FETCH_ASSOC);
                $check->execute();
                $count = $check->rowCount(); 
                $row = $check->fetch();
                if($count>0){
                    $_SESSION['account_id'] = $row['account_id'];
                    $_SESSION['account_name'] = $row['account_name'];
                    $_SESSION['account_email'] = $row['account_email'];
                    $_SESSION['account_password'] = $row['account_password'];
                    $_SESSION['account_image'] = $row['account_image'];
                    $_SESSION['account_type'] = $row['account_type'];
                    header("Location: index.php");
                    die;
                }else{
                    echo "<script>alert('Sai tài khoản hoặc mật khẩu!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/login.php';</script>";
                }
            }
           
        }
    }
    /**================================================== */
?>