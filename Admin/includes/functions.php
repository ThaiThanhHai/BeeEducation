<?php
    include("includes/duration.php");

    /** ==========KHÓA HỌC============= */
    // Hiển thị khóa học
    function view_course(){
        include("includes/database.php");

        $get_course = $con->prepare("SELECT * FROM courses");
        $get_course->setFetchMode(PDO:: FETCH_ASSOC);
        $get_course->execute();
        $i = 1;

        while($row = $get_course->fetch()){
            echo "<tr>
                    <td>".$i."</td>
                    <td>".$row['course_name']."</td>
                    <td><img src='./img/courses/".$row['course_image']."'></td>
                    <td><a href='index.php?courses&edit_course=".$row['course_id']."'><i class='fas fa-edit'></i></a></td>
                    <td><a href='index.php?courses&del_course=".$row['course_id']."' class='confirmDelete'><i class='fas fa-trash-alt'></i></a></td>
                    <td><a href='index.php?courses&view_desrcibe=".$row['course_id']."'><i class='fas fa-eye'></i></a></td>
                    <td>".$row['course_time']."</td>
                  </tr> ";
            $i = $i + 1;
        }


        // Xóa khóa học
        if(isset($_GET['del_course'])){
            $id = $_GET['del_course'];

            $del_course=$con->prepare("DELETE FROM courses WHERE course_id='$id'");

            $get_chapter_del = $con->prepare("SELECT * FROM chapters WHERE course_id = '$id'");
            $get_chapter_del->setFetchMode(PDO:: FETCH_ASSOC);
            $get_chapter_del->execute();

            $get_purpose_del = $con->prepare("SELECT * FROM purpose WHERE course_id = '$id'");
            $get_purpose_del->setFetchMode(PDO:: FETCH_ASSOC);
            $get_purpose_del->execute();


            $kt = 1;
            while($row_chapter_del = $get_chapter_del->fetch()){
                $chapter_id = $row_chapter_del['chapter_id'];
                $del_chapter=$con->prepare("DELETE FROM chapters WHERE chapter_id='$chapter_id'");

                $get_lesson_del = $con->prepare("SELECT * FROM lessons WHERE chapter_id = '$chapter_id'");
                $get_lesson_del->setFetchMode(PDO:: FETCH_ASSOC);
                $get_lesson_del->execute();
                while($row_lesson_del = $get_lesson_del->fetch()){
                    $lesson_id = $row_lesson_del['lesson_id'];
                    $del_lesson=$con->prepare("DELETE FROM lessons WHERE lesson_id='$lesson_id'");

                    if(!$del_lesson->execute()){
                        $kt = 0;
                        break;
                    }

                }

                if(!$del_chapter->execute()){
                    $kt = 0;
                    break;
                }
            } 

            while($row_purpose_del = $get_purpose_del->fetch()){
                $purpose_id = $row_purpose_del['purpose_id'];
                $del_purpose=$con->prepare("DELETE FROM purpose WHERE purpose_id='$purpose_id'");
                if(!$del_purpose->execute()){
                    $kt = 0;
                    break;
                }
            } 

            if($del_course->execute() && $kt==1){
                echo "<script>alert('Đã xóa thành công')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
            }else {
                echo "<script>alert('Xóa thất bại. Vui lòng thử lại sau!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
            }
        }
    }

    function view_desrcibe(){
        //Kết nối csdl
        include("includes/database.php");

        if(isset($_GET['view_desrcibe'])){
            $id=$_GET['view_desrcibe'];
        }
        $get_course = $con->prepare("SELECT * FROM courses WHERE course_id='$id'");
        $get_course->setFetchMode(PDO:: FETCH_ASSOC);
        $get_course->execute();
        
        $i = 1;

        while($row_course = $get_course->fetch()){
            echo "<tr>
                    <td style='height: 420px; width:10%; padding-left: 10px'>".$row_course['course_name']."</td>
                    <td style='height: 420px; padding-right: 10px;'>".$row_course['course_desrcibe']."</td>
                    
                </tr>";
            $i = $i + 1;
        }
    }

    //Thêm khóa học
    function add_course() {
        //Kết nối csdl
        include("includes/database.php");
        //Kiểm tra POST có tồn tại
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //----Kiểm tra tên khóa học
            if(isset($_POST['add_course'])){
                $course_name = trim($_POST['course_name']); //lấy tên và cắt khoảng trắng
                if(empty($course_name)){//nếu tên rỗng, thoát và yêu cầu nhập lại
                    echo "<script>alert('Vui lòng nhập tên khóa học!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                }
                $course_desrcibe = trim($_POST['course_desrcibe']);
            }
            
            

            //----Kiểm tra ảnh khóa học
            $image = $_FILES['course_image'];
            $allow_size = 10; //cho phép tải ảnh nhỏ hơn 10MB
            $course_image = $image['name']; //lấy tên ảnh khóa học

            if(empty($course_image)){//nếu tên rỗng, thoát và yêu cầu nhập lại
                echo "<script>alert('Vui lòng chọn ảnh khóa học!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
            }else{
                //Đổi tên file
                $course_image = explode('.', $course_image); //cắt sau dấu chấm và lưu vào mảng
                $ext = end($course_image); //lấy phần tử cuối của mảng
                $new_course_image = uniqid() . '.' . $ext; //đặt tên mới

                //Kiểm tra định dạng file
                $allow_ext = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
                if(!in_array($ext, $allow_ext)){//Không thỏa điều kiện định dạng
                    echo "<script>alert('Tệp mở rộng phải là đuôi png, jpg, jpeg, gif, webp!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                }else{
                    $size = $image['size']/1024/1024; //byte => megabyte
                    if($size > $allow_size){ //Ko thỏa điều kiện size
                        echo "<script>alert('Kích thước ảnh phải nhỏ hơn 2MB!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                    }else{
                        $upload = move_uploaded_file($image['tmp_name'], 'img/courses/' .$new_course_image);
                        if(!$upload){ 
                            echo "<script>alert('Không thể tải ảnh lên vào thời điểm này. Vui lòng thử lại sau!')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                        }else{
                            //Kiểm tra khóa học có tồn tại trong csdl
                            $check = $con->prepare("SELECT * FROM courses WHERE course_name='$course_name'");
                            $check->setFetchMode(PDO:: FETCH_ASSOC);
                            $check->execute();
                            $count = $check->rowCount(); 
                            if($count > 0){ //khóa học không tồn tại trong csdl
                                echo "<script>alert('Khóa học này đã tồn tại')</script>";
                                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";       
                            }else{
                                $add_courses = $con->prepare("INSERT INTO courses(course_name,course_image,course_desrcibe) values ('$course_name', '$new_course_image', '$course_desrcibe')");
                                if($add_courses->execute()) {
                                    echo "<script>alert('Đã thêm thành công')</script>";
                                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                                    
                                }else {
                                    echo "<script>alert('Thêm thất bại. Vui lòng thử lại sau!')</script>";
                                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                                }
                            }
                        }
                    }
                }
            }
        
        }
    }

    //Chỉnh sửa thông tin khóa học
    function edit_course() {
        include("includes/database.php");

        if(isset($_GET['edit_course'])) {
            $id=$_GET['edit_course'];

            $get_course=$con->prepare("SELECT * FROM courses WHERE course_id='$id'");
            $get_course->setFetchMode(PDO:: FETCH_ASSOC);
            $get_course->execute();
            $row=$get_course->fetch();

            echo "<div class='form-container' style='top: 60px;'>
                    <form method='POST' class='form' id='addCourse-form' enctype='multipart/form-data'>
                        <h4>Chỉnh sửa khóa học</h4>

                        <div class='spacer'></div>                
                        <div class='form-group'>
                            <label for='course_name' class='form-label'>Tên khóa học</label>
                            <input id='course_name' name='course_name' value='".$row['course_name']."' type='text' class='form-control'> 
                        </div>
                        <div class='spacer'></div>
                        <div class='form-group'>
                            <label for='course_image' class='form-label'>Ảnh</label>
                            <input id='course_image' name='course_image' type='file'>
                        </div>
                        <div class='spacer'></div>
                        <div class='form-group'>
                            <label for='course_desrcibe' class='form-label'>Mô tả khóa học</label>
                            <textarea name='course_desrcibe' id='course_desrcibe' cols='20' rows='4'>".$row['course_desrcibe']."</textarea>
                        </div>
                        <div class='form-button'>
                            <input type='submit' name='add_course' class='form-btn save' value='Lưu'>
                            <a href='http://localhost/BeeEducation/Admin/index.php?courses'><input type='button' class='form-btn exit' value='Hủy'></a>
                        </div>
                        <a href='http://localhost/BeeEducation/Admin/index.php?courses'><i class='fas fa-times close'></i></a>
                    </form>
                </div>";

            if($_SERVER['REQUEST_METHOD']=='POST'){
                $course_name = trim($_POST['course_name']); 
                $course_desrcibe = trim($_POST['course_desrcibe']);

                //----Kiểm tra ảnh khóa học
                $image = $_FILES['course_image'];
                $allow_size = 10; //cho phép tải ảnh nhỏ hơn 10MB
                $course_image = $image['name']; //lấy tên ảnh khóa học

                if(empty($course_image)){
                    $edit_course = $con->prepare("UPDATE courses SET course_name='$course_name', course_desrcibe='$course_desrcibe' WHERE course_id='$id'");
                    if($edit_course->execute()) {
                        echo "<script>alert('Cập nhập khóa học thành công')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                    }else {
                        echo "<script>alert('Cập nhật thất bại, vui lòng thử lại sau!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                    }
                }else{
                    //Đổi tên file
                    $course_image = explode('.', $course_image); //cắt sau dấu chấm và lưu vào mảng
                    $ext = end($course_image); //lấy phần tử cuối của mảng
                    $new_course_image = uniqid() . '.' . $ext; //đặt tên mới
    
                    //Kiểm tra định dạng file
                    $allow_ext = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
                    if(!in_array($ext, $allow_ext)){//Không thỏa điều kiện định dạng
                        echo "<script>alert('Tệp mở rộng phải là đuôi png, jpg, jpeg, gif, webp!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                    }else{
                        $size = $image['size']/1024/1024; //byte => megabyte
                        if($size > $allow_size){ //Ko thỏa điều kiện size
                            echo "<script>alert('Kích thước ảnh phải nhỏ hơn 2MB!')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                        }else{
                            $upload = move_uploaded_file($image['tmp_name'], 'img/courses/' .$new_course_image);
                            if(!$upload){ 
                                echo "<script>alert('Không thể tải ảnh lên vào thời điểm này. Vui lòng thử lại sau!')</script>";
                                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                            }else{
                                $edit_course = $con->prepare("UPDATE courses SET course_name='$course_name', course_image='$new_course_image' WHERE course_id='$id'");
                                if($edit_course->execute()) {
                                    echo "<script>alert('Cập nhập khóa học thành công')</script>";
                                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                                }else {
                                    echo "<script>alert('Cập nhật thất bại, vui lòng thử lại sau!')</script>";
                                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?courses';</script>";
                                }
                            }
                        }
                    }
                }   
            }   
        }
    }

    //Select khoa hoc
    function select_course(){
        include("includes/database.php");

        //Lấy khóa học từ bảng coursers để select
        $get_course = $con->prepare("select * from courses");
        $get_course->setFetchMode(PDO:: FETCH_ASSOC);
        $get_course->execute();
        while($row_course = $get_course->fetch()){
            echo "<option value='".$row_course['course_id']."'>".$row_course['course_name']."</option>";
        }        
    }

    /**================================== */



    /**=============CHỦ ĐỀ=============== */
    // Thêm chủ đề
    function add_chapter() {
        //Kết nối csdl
        include("includes/database.php");
        //Kiểm tra POST có tồn tại
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //----Kiểm tra tên chủ đề
            if(isset($_POST['add_chapter'])){
                $chapter_name = trim($_POST['chapter_name']);
                $chapter_course =  $_POST['chapter_course'];
                if(empty($chapter_name)){
                    echo "<script>alert('Vui lòng nhập tên chủ đề!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?chapters';</script>";
                }
            }
            
            //Kiểm tra chủ đề có tồn tại trong csdl
            $check = $con->prepare("select * from chapters where chapter_name='$chapter_name' and course_id='$chapter_course' ");
            $check->setFetchMode(PDO:: FETCH_ASSOC);
            $check->execute();
            $count = $check->rowCount(); 
            if($count > 0){ 
                echo "<script>alert('Tên chủ đề này đã tồn tại')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?chapters';</script>";       
            }else{
                $add_chapter = $con->prepare("insert into chapters(chapter_name,course_id) values ('$chapter_name', '$chapter_course')");
                if($add_chapter->execute()) {
                    echo "<script>alert('Đã thêm thành công')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?chapters';</script>";
                    
                }else {
                    echo "<script>alert('Thêm thất bại. Vui lòng thử lại sau!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?chapters';</script>";
                }
            }
        
        }
    }

    // Hiển thị khóa học
    function view_chapter(){
        include("includes/database.php");

        $get_chapter = $con->prepare("select * from chapters");
        $get_chapter->setFetchMode(PDO:: FETCH_ASSOC);
        $get_chapter->execute();
        $i = 1;

        while($row_chapter = $get_chapter->fetch()){
            $id = $row_chapter['course_id'];
            $get_course = $con->prepare("select * from courses where course_id = '$id'");
            $get_course->setFetchMode(PDO:: FETCH_ASSOC);
            $get_course->execute();
            $row_course = $get_course->fetch();

            echo "<tr>
                    <td>".$i."</td>
                    <td> <textarea rows='1'>".$row_chapter['chapter_name']."</textarea></td>
                    <td><textarea rows='1'>".$row_course['course_name']."</textarea></td>
                    <td><a href='index.php?chapters&edit_chapter=".$row_chapter['chapter_id']."'><i class='fas fa-edit'></i></a></td>
                    <td><a href='index.php?chapters&del_chapter=".$row_chapter['chapter_id']."' class='confirmDelete'><i class='fas fa-trash-alt'></i></a></td>
                    <td>".$row_chapter['chapter_time']."</td>
                </tr>";
                $i = $i + 1;
        }


        //Xóa chủ đề
        if(isset($_GET['del_chapter'])){
            $id = $_GET['del_chapter'];

            $del_chapter=$con->prepare("delete from chapters where chapter_id='$id'");
            
            $get_lesson_del = $con->prepare("select * from lessons where chapter_id = '$id'");
            $get_lesson_del->setFetchMode(PDO:: FETCH_ASSOC);
            $get_lesson_del->execute();
            $kt = 1;
            while($row_lesson_del = $get_lesson_del->fetch()){
                $lesson_id = $row_lesson_del['lesson_id'];
                $del_lesson=$con->prepare("delete from lessons where lesson_id='$lesson_id'");
                if(!$del_lesson->execute()){
                    $kt = 0;
                    break;
                }
            } 

            if($del_chapter->execute() && $kt==1){
                echo "<script>alert('Đã xóa thành công')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?chapters';</script>";
            }else {
                echo "<script>alert('Xóa thất bại. Vui lòng thử lại sau!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?chapters';</script>";
            }
        }
    }

    //Chỉnh sửa thông tin khóa học
    function edit_chapter() {
        include("includes/database.php");

        if(isset($_GET['edit_chapter'])) {
            $id=$_GET['edit_chapter'];

            $get_chapter=$con->prepare("select * from chapters where chapter_id='$id'");
            $get_chapter->setFetchMode(PDO:: FETCH_ASSOC);
            $get_chapter->execute();
            $row=$get_chapter->fetch();

            echo "<div class='form-container' style='top: 60px;'>
                <form action='' method='POST' class='form' id='addChapter-form' enctype='multipart/form-data'>
                <h4>Chỉnh sửa chủ đề</h4>
        
                <div class='spacer'></div>
                <div class='form-group'>
                    <label for='chapter_name' class='form-label'>Tên chủ đề</label>
                    <input id='chapter_name' name='chapter_name' required type='text' class='form-control' value='".$row['chapter_name']."'>
                </div>
        
                <div class='spacer'></div>
                <div class='form-group'>
                        <label for='chapter_course' class='form-label'>Khóa học</label>
                        <select name='chapter_course' id='chapter_course' class='select-control'>
                                <option style='font-size: 16px; color:#000;' disabled>----Chọn khóa học----</option>";
                                echo select_course();
                echo "</select>
                </div>
        
                <div class='form-button'>
                    <input type='submit' name='edit_chapter' class='form-btn save' value='Lưu'>
                    <a href='http://localhost/BeeEducation/Admin/index.php?chapters'><input type='button' class='form-btn exit' value='Hủy'></a>
                </div>
                <a href='http://localhost/BeeEducation/Admin/index.php?chapters'><i class='fas fa-times close'></i></a>
            </form>
            </div>";

            if($_SERVER['REQUEST_METHOD']=='POST'){
                //----Kiểm tra tên chủ đề
                if(isset($_POST['edit_chapter'])){
                    $chapter_name = trim($_POST['chapter_name']);
                    $chapter_course =  $_POST['chapter_course'];
                    if(empty($chapter_name)){
                        echo "<script>alert('Vui lòng nhập tên chủ đề!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?chapters';</script>";
                    }
                }
                
                $update_chapter = $con->prepare("update chapters set chapter_name='$chapter_name', course_id='$chapter_course' where chapter_id='$id'");
                if($update_chapter->execute()) {
                    echo "<script>alert('Đã cập nhật thành công')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?chapters';</script>";
                    
                }else {
                    echo "<script>alert('Cập nhật thất bại. Vui lòng thử lại sau!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?chapters';</script>";
                }
            
            }
            
        }
    }

    //Select chủ đề
    function select_course_chapter(){
        include("includes/database.php");
        if(isset($_GET['add_lesson'])){
            $id = $_GET['add_lesson'];
        }

        //Lấy chủ đề từ bảng chapters để select
        $get_chapter = $con->prepare("select * from chapters where course_id='$id'");
        $get_chapter->setFetchMode(PDO:: FETCH_ASSOC);
        $get_chapter->execute();
        while($row_chapter = $get_chapter->fetch()){
            echo "<option value='".$row_chapter['chapter_id']."'>".$row_chapter['chapter_name']."</option>";
        }        
        
    }

    function select_chapter(){
        include("includes/database.php");
        if(isset($_GET['edit_lesson'])){
            $lesson_id = $_GET['edit_lesson'];
        }
        $get_lesson1 = $con->prepare("select * from lessons where 
        lesson_id='$lesson_id'");
        $get_lesson1->setFetchMode(PDO:: FETCH_ASSOC);
        $get_lesson1->execute();
        $row_lesson1 = $get_lesson1->fetch();
        $chapter_id1 = $row_lesson1['chapter_id'];

        $get_chapter1 = $con->prepare("select * from chapters where chapter_id='$chapter_id1'");
        $get_chapter1->setFetchMode(PDO:: FETCH_ASSOC);
        $get_chapter1->execute();
        $row_chapter1 = $get_chapter1->fetch();
        $chapter_course1 = $row_chapter1['course_id'];

        $get_chapter2 = $con->prepare("select * from chapters where course_id='$chapter_course1'");
        $get_chapter2->setFetchMode(PDO:: FETCH_ASSOC);
        $get_chapter2->execute();

        while($row_chapter2 = $get_chapter2->fetch()){
            echo "<option value='".$row_chapter2['chapter_id']."'>".$row_chapter2['chapter_name']."</option>";
        }        
        
    }
    /**=================================== */




    /**============BÀI GIẢNG============== */
    /*Thêm bài giảng vào khóa học*/
    function add_lesson(){
        include("includes/database.php");
        //Kiểm tra POST có tồn tại
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_POST['add_lesson'])){
                $lesson_title = trim($_POST['lesson_title']);
                $lesson_link = trim($_POST['lesson_link']);
                $lesson_chapter = $_POST['lesson_chapter'];
                $lesson_desrcibe = trim($_POST['lesson_desrcibe']);
            }
            
            $duration = getYoutubeVideo($lesson_link);
            $lesson_duration = convert_time($duration) - 1;

            if(empty($lesson_title)){
                echo "<script>alert('Tiêu đề bài giảng không được để trống!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?lessons';</script>";
            }else if(empty($lesson_chapter)){
                echo "<script>alert('Chủ đề không được để trống, vui lòng thêm chủ đề trước khi thêm bài giảng!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?lessons';</script>";
            }else{
                //Kiểm tra bài giảng có tồn tại trong csdl
                $check = $con->prepare("SELECT * FROM lessons WHERE lesson_title='$lesson_title' AND lesson_link='$lesson_link'");
                $check->setFetchMode(PDO:: FETCH_ASSOC);
                $check->execute();
                $count = $check->rowCount(); 
                if($count>0){
                    echo "<script>alert('Thông tin đã tồn tại trong CSDL, vui lòng kiểm tra lại!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?lessons';</script>";
                }else{
                    $add_lesson = $con->prepare("INSERT INTO lessons(lesson_title,	lesson_link, lesson_desrcibe,lesson_duration, chapter_id) values ('$lesson_title', '$lesson_link','$lesson_desrcibe', '$lesson_duration', '$lesson_chapter')");
                    if($add_lesson->execute()) {
                        echo "<script>alert('Đã thêm thành công')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?lessons';</script>";
                    }else {
                        echo "<script>alert('Thêm thất bại. Vui lòng thử lại sau!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?lessons';</script>";
                    }
                }
            }
        }
    }

    //Hiển thị bài giảng khóa học
    function view_lesson() {
        include("includes/database.php");

        $get_lesson = $con->prepare("select * from lessons");
        $get_lesson->setFetchMode(PDO:: FETCH_ASSOC);
        $get_lesson->execute();
        
        $i = 1;

        while($row_lesson = $get_lesson->fetch()){
            //Lấy tên khóa học trong bảng courses
            $chapter_id = $row_lesson['chapter_id'];
            $get_chapter = $con->prepare("SELECT * FROM chapters WHERE chapter_id='$chapter_id'");
            $get_chapter->setFetchMode(PDO:: FETCH_ASSOC);
            $get_chapter->execute();
            $row_chapter = $get_chapter->fetch();

            $course_id = $row_chapter['course_id'];
            $get_course = $con->prepare("SELECT * FROM courses WHERE course_id='$course_id'");
            $get_course->setFetchMode(PDO:: FETCH_ASSOC);
            $get_course->execute();
            $row_course = $get_course->fetch();
            echo "  <tr>
                        <td>".$i."</td>
                        <td><textarea class='scroll' rows='1'>".$row_lesson['lesson_title']."</textarea></td>
                        <td><textarea class='scroll' rows='1'>".$row_chapter['chapter_name']."</textarea></td>
                        <td><textarea class='scroll' rows='1'>".$row_course['course_name']."</textarea></td>
                        <td><a href='index.php?lessons&edit_lesson=".$row_lesson['lesson_id']."'><i class='fas fa-edit'></i></a></td>
                        <td><a href='index.php?lessons&del_lesson=".$row_lesson['lesson_id']."' class='confirmDelete'><i class='fas fa-trash-alt'></i></a></td>
                        <td><a href='index.php?lessons&view_detail=".$row_lesson['lesson_id']."'><i class='fas fa-eye'></i></a></td>
                        <td>".$row_lesson['lesson_time']."</td>
                    </tr>";
            $i = $i + 1;
        }

        // Xóa bài giảng khóa học
        if(isset($_GET['del_lesson'])){
            $id = $_GET['del_lesson'];

            $del_lesson=$con->prepare("DELETE FROM lessons WHERE lesson_id='$id'");

            if($del_lesson->execute()){
                echo "<script>alert('Đã xóa thành công')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?lessons';</script>";
            }else {
                echo "<script>alert('Xóa thất bại. Vui lòng thử lại sau!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?lessons';</script>";
            }
        }
    }

    //Chỉnh sửa thông tin bài giảng
    function edit_lesson() {
        include("includes/database.php");

        if(isset($_GET['edit_lesson'])){
            $id=$_GET['edit_lesson'];

            $get_lesson=$con->prepare("SELECT * FROM lessons WHERE lesson_id='$id'");
            $get_lesson->setFetchMode(PDO:: FETCH_ASSOC);
            $get_lesson->execute();
            $row=$get_lesson->fetch();

            echo "<div class='form-container' style='top:60px'>
            <form method='POST' class='form' id='addLessons-form' enctype='multipart/form-data'>
                <h4>Chỉnh sửa thông tin bài giảng</h4>
           
                <div class='spacer'></div>
                <div class='form-group'>
                    <label for='lesson_title' class='form-label'>Tiêu đề</label>
                    <input type='text' id='lesson_title' name='lesson_title' required value='".$row['lesson_title']."' class='form-control'>
                </div>
        
                <div class='spacer'></div>
                <div class='form-group'>
                    <label for='lesson_link' class='form-label'>Link video</label>
                    <input type='url' id='lesson_link' name='lesson_link' required value='".$row['lesson_link']."' class='form-control'>
                </div>
        
                <div class='spacer'></div>
                <div class='form-group'>
                        <select name='lesson_chapter' id='lesson_chapter' class='select-control'>
                                <option style='font-size: 16px; color:#000;' disabled>----Chọn khóa học----</option>";
                                echo select_chapter(); 
                   echo "</select>
                </div>
        
                <div class='spacer'></div>
                <div class='form-group'>
                    <label for='lesson_desrcibe' class='form-label'>Mô tả</label>
                    <textarea name='lesson_desrcibe' id='lesson_desrcibe' cols='20' rows='4'>".$row['lesson_desrcibe']."</textarea>
                </div>
                
                <div class='form-button'>
                    <input type='submit' name='edit_lesson' class='form-btn save' value='Lưu'>
                    <a href=' http://localhost/BeeEducation/Admin/index.php?lessons'><input type='button' class='form-btn exit' value='Hủy'></a>  
                </div>
                <a href='http://localhost/BeeEducation/Admin/index.php?lessons'><i class='fas fa-times close'></i></a>
                </form>
            </div>";

            ////Kiểm tra POST có tồn tại
            if($_SERVER['REQUEST_METHOD']=='POST'){
                if(isset($_POST['edit_lesson'])){
                    $lesson_title = trim($_POST['lesson_title']);
                    $lesson_link = trim($_POST['lesson_link']);
                    $lesson_chapter = $_POST['lesson_chapter'];
                    $lesson_desrcibe = trim($_POST['lesson_desrcibe']);
                }

                $duration = getYoutubeVideo($lesson_link);
                $lesson_duration = convert_time($duration) - 1;

                if(empty($lesson_title)){
                    echo "<script>alert('Tiêu đề bài giảng không được để trống!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?lessons';</script>";
                }else{
                    $update_lesson = $con->prepare("UPDATE lessons SET lesson_title='$lesson_title', lesson_link='$lesson_link', lesson_desrcibe='$lesson_desrcibe', lesson_duration='$lesson_duration', chapter_id='$lesson_chapter' WHERE lesson_id='$id'");
                    if($update_lesson->execute()) {
                        echo "<script>alert('Cập nhập bài giảng thành công')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?lessons';</script>";
                    }else {
                        echo "<script>alert('Cập nhật thất bại, vui lòng thử lại sau!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?lessons';</script>";
                    }
                }
            }
        
        }
    }

    function view_detail(){
        //Kết nối csdl
        include("includes/database.php");

        if(isset($_GET['view_detail'])){
            $id=$_GET['view_detail'];
        }
        $get_lesson = $con->prepare("SELECT * FROM lessons WHERE lesson_id='$id'");
        $get_lesson->setFetchMode(PDO:: FETCH_ASSOC);
        $get_lesson->execute();
        
        $i = 1;

        while($row_lesson = $get_lesson->fetch()){
            $video_time = chang_time($row_lesson['lesson_duration']);
            echo "<tr>
                    <td style='height: 420px; width:20%; padding-left:6px;'>".$row_lesson['lesson_title']."</td>
                    <td style='height: 420px; width:15%; padding-left:6px;'>".$row_lesson['lesson_link']."</td>
                    <td style='height: 420px; width:42%; padding-left:6px;'>".$row_lesson['lesson_desrcibe']."</td>
                    <td style='height: 420px; width:10%; padding-left:6px;'>".$video_time."</td>
                </tr>";
            $i = $i + 1;
        }



        
    }
    /**==================================== */




    // /**============TÀI KHOẢN=============== */
    // //Tạo tài khoản
    function add_account(){
        //Kết nối csdl
        include("includes/database.php");
        //Kiểm tra POST có tồn tại
        if($_SERVER['REQUEST_METHOD']=='POST'){
            
            if(isset($_POST['add_account'])){
                $account_name = trim($_POST['account_name']);
                $account_email = trim($_POST['account_email']);
                $account_password = hash('sha1', trim($_POST['account_password']));
                $account_type = trim($_POST['account_type']);

                
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
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                    }else{
                        $size = $image['size']/1024/1024; //byte => megabyte
                        if($size > $allow_size){ //Ko thỏa điều kiện size
                            echo "<script>alert('Kích thước ảnh phải nhỏ hơn 2MB!')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                        }else{
                            $upload = move_uploaded_file($image['tmp_name'], 'img/accounts/' .$new_account_image);
                            if(!$upload){ 
                                echo "<script>alert('Không thể tải ảnh lên vào thời điểm này. Vui lòng thử lại sau!')</script>";
                                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                            }else{
                                //Kiểm tra tài khoản có tồn tại trong csdl
                                $check = $con->prepare("SELECT * FROM accounts WHERE account_name='$account_name'");
                                $check->setFetchMode(PDO:: FETCH_ASSOC);
                                $check->execute();
                                $count = $check->rowCount(); 
                                if($count > 0){ //tài khoản tồn tại trong csdl
                                    echo "<script>alert('Khóa học này đã tồn tại')</script>";
                                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";       
                                }else{
                                    $add_account = $con->prepare("INSERT INTO accounts(account_name,account_email,account_password,account_type,account_image) VALUES ('$account_name','$account_email', '$account_password','$account_type','$new_account_image')");
                                    if($add_account->execute()) {
                                        echo "<script>alert('Đã tạo tài khoản thành công')</script>";
                                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                                        
                                    }else {
                                        echo "<script>alert('Thêm thất bại. Vui lòng thử lại sau!')</script>";
                                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                                    }
                                }
                            }
                        }
                    }
                }else{
                    $account_image = "Không có";
                    //Kiểm tra tài khoản có tồn tại trong csdl
                    $check = $con->prepare("SELECT * FROM accounts WHERE account_name='$account_name'");
                    $check->setFetchMode(PDO:: FETCH_ASSOC);
                    $check->execute();
                    $count = $check->rowCount(); 
                    if($count > 0){ //tài khoản tồn tại trong csdl
                        echo "<script>alert('Tài khoản này đã tồn tại')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";       
                    }else{
                        $add_account = $con->prepare("INSERT INTO accounts(account_name,account_email,account_password,account_type,account_image) VALUES ('$account_name','$account_email', '$account_password','$account_type','$account_image')");
                        if($add_account->execute()) {
                            echo "<script>alert('Đã tạo tài khoản thành công')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                            
                        }else {
                            echo "<script>alert('Thêm thất bại. Vui lòng thử lại sau!')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                        }
                    }  
                 }                
            }
        }
    }

    // //Hiển thị thông tin tài khoản
    function view_account(){
        include("includes/database.php");

        $get_account = $con->prepare("SELECT * FROM accounts");
        $get_account->setFetchMode(PDO:: FETCH_ASSOC);
        $get_account->execute();
        $i = 1;

        while($row_account = $get_account->fetch()){
            echo "<tr>
            <td>".$i."</td>
            <td>".$row_account['account_name']."</td>
            <td><textarea cols='30' rows='1'>".$row_account['account_email']."</textarea> </td>
            <td><textarea cols='30' rows='1'>".$row_account['account_password']."</textarea></td>";
            if($row_account['account_image']=="Không có"){
                echo " <td><img src='./img/accounts/unnamed.png'></td>";
            }else{
                echo " <td><img src='./img/accounts/".$row_account['account_image']."'></td>";
            }
            echo "<td>".$row_account['account_type']."</td>
                <td><a href='index.php?accounts&edit_account=".$row_account['account_id']."'><i class='fas fa-edit'></i></a></td>
                <td><a href='index.php?accounts&del_account=".$row_account['account_id']."' class='confirmDelete'><i class='fas fa-trash-alt'></i></a></td>
                <td>".$row_account['account_time']."</td>
            </tr>";
            $i = $i + 1;
        }

         // Xóa tài khoản
         if(isset($_GET['del_account'])){
            $id = $_GET['del_account'];

            $del_account=$con->prepare("DELETE FROM accounts WHERE account_id='$id'");

            if($del_account->execute()){
                echo "<script>alert('Đã xóa tài khoản thành công')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
            }else {
                echo "<script>alert('Xóa thất bại. Vui lòng thử lại sau!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
            }
        }
    }

    // //Sửa đổi thông tin tài khoản
    function edit_account(){
        include("includes/database.php");

        if(isset($_GET['edit_account'])){
            $id=$_GET['edit_account'];

            $get_account=$con->prepare("SELECT * FROM accounts WHERE account_id='$id'");
            $get_account->setFetchMode(PDO:: FETCH_ASSOC);
            $get_account->execute();
            $row=$get_account->fetch();

            echo "<div class='form-container' style='top: 60px;'>
            <form method='POST' class='form' id='editAccounts-form' enctype='multipart/form-data' onsubmit='return validateform()'>
                <h4>Chỉnh sửa thông tin tài khoản</h4>
           
                <div class='spacer'></div>
                <div class='form-group'>
                    <input type='text' id='account_name' name='account_name' class='form-control' required placeholder='Họ tên' value='".$row['account_name']."'>
                </div>
        
                <div class='spacer'></div>
                <div class='form-group'>
                    <input type='email' id='account_email' name='account_email' required class='form-control' placeholder='Email' value='".$row['account_email']."'>
                </div>
        
                <div class='spacer'></div>
                <div class='form-group'>
                    <input type='password' id='account_password' name='account_password' required class='form-control' placeholder='Mật khẩu' value='".$row['account_password']."' >
                </div>
        
                <div class='spacer'></div>
                <div class='form-group'>
                    <input type='password' id='account_password1' name='account_password1' required class='form-control' placeholder='Nhập lại mật khẩu' value='".$row['account_password']."'>
                </div>
        
                <div class='spacer'></div>
                <div class='form-group'>
                    <div class='box-file'>
                        <input type='file' id='account_image' name='account_image' >
                        
                    </div>
                </div>
        
                <div class='spacer'></div>
                <div class='form-group'>
                    <div class='box-radio'>";
                    if($row['account_type'] == 'User'){
                       echo " <input type='radio' name='account_type' id='users' value='User' checked='checked'>
                       <label style='margin-right: 15px;' for='users'>Học viên</label>
                       <input type='radio' name='account_type' id='admin' value='Admin'>
                       <label style='margin-left: 15px;' for='admin'>Quản trị viên</label>";
                    }else if($row['account_type'] == 'Admin'){
                        echo "<input type='radio' name='account_type' id='users' value='User'>
                        <label style='margin-right: 15px;' for='users'>Học viên</label>
                        <input type='radio' name='account_type' id='admin' value='Admin' checked='checked'>
                        <label style='margin-left: 15px;' for='admin'>Quản trị viên</label>";
                    }
                echo "</div>
                    </div>       
                    <div class='form-button' style='margin-top:40px;'>
                        <input type='submit' name='edit_account' class='form-btn save' value='Lưu'>
                        <a href=' http://localhost/BeeEducation/Admin/index.php?accounts'><input type='button' class='form-btn exit' value='Hủy'></a>  
                    </div>
                    <a href='http://localhost/BeeEducation/Admin/index.php?accounts'><i class='fas fa-times close'></i></a>
                </form>
            </div>";

            if($_SERVER['REQUEST_METHOD']=='POST'){
                if(isset($_POST['edit_account'])){
                    $account_name = trim($_POST['account_name']);
                    $account_email = trim($_POST['account_email']);
                    $account_password = trim($_POST['account_password']);
                    $account_type = trim($_POST['account_type']);
    
                    
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
                            echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                        }else{
                            $size = $image['size']/1024/1024; //byte => megabyte
                            if($size > $allow_size){ //Ko thỏa điều kiện size
                                echo "<script>alert('Kích thước ảnh phải nhỏ hơn 2MB!')</script>";
                                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                            }else{
                                $upload = move_uploaded_file($image['tmp_name'], 'img/accounts/' .$new_account_image);
                                if(!$upload){ 
                                    echo "<script>alert('Không thể tải ảnh lên vào thời điểm này. Vui lòng thử lại sau!')</script>";
                                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                                }else{    
                                    $edit_account = $con->prepare("update accounts set account_name='$account_name', account_email='$account_email', account_password='$account_password', account_type='$account_type', account_image='$new_account_image' where account_id='$id'");
                                    if($edit_account->execute()) {
                                        echo "<script>alert('Chỉnh sửa tài khoản thành công')</script>";
                                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                                        
                                    }else {
                                        echo "<script>alert('Chỉnh sửa thất bại. Vui lòng thử lại sau!')</script>";
                                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                                    }   
                                }
                            }
                        }
                    }else{ 
                        $edit_account = $con->prepare("update accounts set account_name='$account_name', account_email='$account_email', account_password='$account_password', account_type='$account_type' where account_id='$id'");
                        if($edit_account->execute()) {
                            echo "<script>alert('Chỉnh sửa tài khoản thành công')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                            
                        }else {
                            echo "<script>alert('Chỉnh sửa thất bại. Vui lòng thử lại sau!')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?accounts';</script>";
                        }  
                    }                
                }
            }
        }
    }
    // /**===================================== */

    /**==============BÀI VIẾT================== */
    function view_blog(){
        include("includes/database.php");

        $get_blog = $con->prepare("SELECT * FROM blogs");
        $get_blog->setFetchMode(PDO:: FETCH_ASSOC);
        $get_blog->execute();
        $i = 1;
        while($row_blog = $get_blog->fetch()){
            echo "<tr>
                        <td>".$i."</td>
                        <td class='title'>".$row_blog['blog_title']."</td>
                        <td><img src='./img/blogs/image_title/".$row_blog['blog_image']."'></td>
                        <td>";if($row_blog['blog_status']==0){
                            echo "<form method='POST' >
                            <input type='submit' name='approve' class='btn' value='Duyệt'>
                            <input type='text' class='blog_id' name='blog_id' value='".$row_blog['blog_id']."' style='opacity:0;width:10px;'>
                            </form>";
                            approve();
                        }else{
                            echo "<p>Đã duyệt</p>";
                        } echo "</td>
                        <td><a href='index.php?blogs&edit_blog=".$row_blog['blog_id']."'><i class='fas fa-edit'></i></a></td>
                        <td><a href='index.php?blogs&del_blog=".$row_blog['blog_id']."' class='confirmDelete'><i class='fas fa-trash-alt'></i></a></td>
                        <td><a href='index.php?blogs&view_content='><i class='fas fa-eye'></i></a></td>
                        <td>".$row_blog['blog_time']."</td>
                    </tr>";
            $i =  $i + 1;
        }

         //Xóa chủ đề
         if(isset($_GET['del_blog'])){
            $id = $_GET['del_blog'];

            $del_blog=$con->prepare("DELETE FROM blogs WHERE blog_id='$id'");
            
            if($del_blog->execute()){
                echo "<script>alert('Đã xóa thành công')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
            }else {
                echo "<script>alert('Xóa thất bại. Vui lòng thử lại sau!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
            }
        }
    }

    function view_content(){
        include("includes/database.php");

        $get_blog = $con->prepare("SELECT * FROM blogs");
        $get_blog->setFetchMode(PDO:: FETCH_ASSOC);
        $get_blog->execute();
        $i = 1;
        while($row_blog = $get_blog->fetch()){
            echo "<tr>
                    <textarea name='content' id='content' placeholder='Đây là nội dung...' rows='10' cols='80'>".$row_blog['blog_content']."</textarea>     
                </tr>";
            $i =  $i + 1;
        }
    }

    function edit_blog(){
        //Kết nối csdl
        include("includes/database.php");

        if(isset($_GET['edit_blog'])) {
            $id=$_GET['edit_blog'];

            $get_blog=$con->prepare("SELECT * FROM blogs WHERE blog_id='$id'");
            $get_blog->setFetchMode(PDO:: FETCH_ASSOC);
            $get_blog->execute();
            $row_blog=$get_blog->fetch();

            echo "<div class='form-container' style='top:60px'>
                        <form action='' method='POST' class='form' style='width:1000px' id='editIntro-form' enctype='multipart/form-data'>
                            <div class='spacer'></div>
                            <input type='text' value='".$row_blog['blog_title']."' name='blog-title'  class='form-control' style='width:600px;'>      
                            <input type='file' name='blog-imgae' >
                            <div class='spacer' ></div>
                            <textarea name='content' id='content' placeholder='Đây là nội dung...' rows='10' cols='80'>".$row_blog['blog_content']."</textarea>
                            <div class='form-button'>
                                <input type='submit' name='edit_blog' class='form-btn save' value='Lưu'>
                                <a href='http://localhost/BeeEducation/Admin/index.php?setup&intro'><input type='button' class='form-btn exit' value='Hủy'></a>
                            </div>
                            <a href='http://localhost/BeeEducation/Admin/index.php?setup&intro'><i class='fas fa-times close'></i></a>
                        </form>
                    </div>";

            //Kiểm tra POST có tồn tại
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //----Kiểm tra tên chủ đề
            if(isset($_POST['edit_blog'])){
                $blog_content =  $_POST['content'];
                $blog_title = $_POST['blog-title'];
                if(empty($blog_title)){
                    echo "<script>alert('Vui lòng nhập tiêu đề bài viết!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
                }
                if(empty($blog_content)){
                    echo "<script>alert('Vui lòng nhập nội dung bài viết!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
                }
            }

            //----Kiểm tra ảnh tiêu đề
            $image = $_FILES['blog-imgae'];
            $allow_size = 10; //cho phép tải ảnh nhỏ hơn 10MB
            $blog_image = $image['name']; //lấy tên ảnh khóa học

            if(empty($blog_image)){//nếu tên rỗng, thoát và yêu cầu nhập lại
                // $edit_blog = $con->prepare("UPDATE  blogs(blog_title,blog_image,blog_content, account_id) VALUES ('$blog_title','$new_blog_image','$blog_content', 1)");
                // $edit_intro = $con->prepare("UPDATE intro SET intro_content='$intro_content', account_id=1 WHERE intro_id='$id'");
                $edit_blog = $con->prepare("UPDATE blogs SET blog_title='$blog_title', blog_content='$blog_content' WHERE blog_id='$id'");
                if($edit_blog->execute()) {
                    echo "<script>alert('Đã cập nhật thành công')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
                }else {
                    echo "<script>alert('Cập nhật thất bại. Vui lòng thử lại sau!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
                }
            }else{
                //Đổi tên file
                $blog_image = explode('.', $blog_image); //cắt sau dấu chấm và lưu vào mảng
                $ext = end($blog_image); //lấy phần tử cuối của mảng
                $new_blog_image = uniqid() . '.' . $ext; //đặt tên mới

                //Kiểm tra định dạng file
                $allow_ext = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
                if(!in_array($ext, $allow_ext)){//Không thỏa điều kiện định dạng
                    echo "<script>alert('Tệp mở rộng phải là đuôi png, jpg, jpeg, gif, webp!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
                }else{
                    $size = $image['size']/1024/1024; //byte => megabyte
                    if($size > $allow_size){ //Ko thỏa điều kiện size
                        echo "<script>alert('Kích thước ảnh phải nhỏ hơn 2MB!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
                    }else{
                        $upload = move_uploaded_file($image['tmp_name'], 'Admin/img/blogs/image_title/' .$new_blog_image);
                        if(!$upload){ 
                            echo "<script>alert('Không thể tải ảnh lên vào thời điểm này. Vui lòng thử lại sau!')</script>";
                            echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
                        }else{
                            $edit_blog = $con->prepare("UPDATE blogs SET blog_title='$blog_title',blog_image='$new_blog_image', blog_content='$blog_content' WHERE blog_id='$id'");
                            if($edit_blog->execute()) {
                                echo "<script>alert('Đã cập nhật thành công')</script>";
                                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
                            }else {
                                echo "<script>alert('Cập nhật thất bại. Vui lòng thử lại sau!')</script>";
                                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
                            }
                        }
                    }
                }
            }
        }
            
        }
    }

    function approve(){
        //Kết nối csdl
        include("includes/database.php");

        if(isset($_POST['approve'])) {
            $blog_id = $_POST['blog_id'];
            print($blog_id);
            $get_blog = $con->prepare("SELECT * FROM blogs WHERE blog_id='$blog_id'");
            $get_blog->setFetchMode(PDO:: FETCH_ASSOC);
            $get_blog->execute();
            $row_blog = $get_blog->fetch();

            $blog_id = $row_blog['blog_id'];

            $approve = $con->prepare("UPDATE blogs SET blog_status=1 WHERE blog_id='$blog_id'");
            if($approve->execute()) {
                echo "<script>alert('Đã duyệt thành công')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
            }else {
                echo "<script>alert('Duyệt thất bại. Vui lòng thử lại sau!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?blogs';</script>";
            }
        }
    }


    /**======================================== */

    /**==============CÀI ĐẶT================ */
    //Thêm yêu cầu
    function add_purpose() {
        //Kết nối csdl
        include("includes/database.php");
        //Kiểm tra POST có tồn tại
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //----Kiểm tra tên chủ đề
            if(isset($_POST['add_purpose'])){
                $purpose_content = trim($_POST['purpose_content']);
                $purpose_course =  $_POST['purpose_course'];
                if(empty($purpose_content)){
                    echo "<script>alert('Vui lòng nhập nội dung yêu cầu!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?chapters';</script>";
                }
            }
            
            //Kiểm tra chủ đề có tồn tại trong csdl
            $check = $con->prepare("SELECT * FROM purpose WHERE purpose_content='$purpose_content' AND course_id='$purpose_course' ");
            $check->setFetchMode(PDO:: FETCH_ASSOC);
            $check->execute();
            $count = $check->rowCount(); 
            if($count > 0){ 
                echo "<script>alert('Yêu cầu của khóa học này đã tồn tại')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&purpose';</script>";       
            }else{
                $add_purpose = $con->prepare("INSERT INTO purpose(purpose_content,course_id) VALUES ('$purpose_content', '$purpose_course')");
                if($add_purpose->execute()) {
                    echo "<script>alert('Đã thêm thành công')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&purpose';</script>";
                    
                }else {
                    echo "<script>alert('Thêm thất bại. Vui lòng thử lại sau!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&purpose';</script>";
                }
            }
        
        }
    }

    // Hiển thị yêu cầu khóa học
    function view_purpose(){
        include("includes/database.php");

        $get_purpose = $con->prepare("SELECT * FROM purpose");
        $get_purpose->setFetchMode(PDO:: FETCH_ASSOC);
        $get_purpose->execute();
        $i = 1;

        while($row_purpose = $get_purpose->fetch()){
            $id =$row_purpose['course_id'];
            $get_course = $con->prepare("SELECT * FROM courses WHERE course_id = '$id'");
            $get_course->setFetchMode(PDO:: FETCH_ASSOC);
            $get_course->execute();
            $row_course = $get_course->fetch();

            echo " <tr>
                        <td>".$i."</td>
                        <td><textarea rows='2'>".$row_purpose['purpose_content']."</textarea></td>
                        <td>".$row_course['course_name']."</td>
                        <td><a href='index.php?setup&purpose&edit_purpose=".$row_purpose['purpose_id']."'><i class='fas fa-edit'></i></a></td>
                        <td><a href='index.php?setup&purpose&del_purpose=".$row_purpose['purpose_id']."' class='confirmDelete'><i class='fas fa-trash-alt'></i></a></td>
                        <td>".$row_purpose['purpose_time']."</td>
                    </tr>";
                $i = $i + 1;
        }


        //Xóa chủ đề
        if(isset($_GET['del_purpose'])){
            $id = $_GET['del_purpose'];

            $del_purpose=$con->prepare("DELETE FROM purpose WHERE purpose_id='$id'");
            
            if($del_purpose->execute()){
                echo "<script>alert('Đã xóa thành công')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&purpose';</script>";
            }else {
                echo "<script>alert('Xóa thất bại. Vui lòng thử lại sau!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&purpose';</script>";
            }
        }
    }

    //Chỉnh sửa thông tin yêu cầu khóa học
    function edit_purpose() {
        include("includes/database.php");

        if(isset($_GET['edit_purpose'])) {
            $id=$_GET['edit_purpose'];

            $get_purpose=$con->prepare("SELECT * FROM purpose WHERE purpose_id='$id'");
            $get_purpose->setFetchMode(PDO:: FETCH_ASSOC);
            $get_purpose->execute();
            $row=$get_purpose->fetch();

            echo "<div class='form-container' style='top: 60px;'>
                <form action='' method='POST' class='form' id='addPurpose-form' enctype='multipart/form-data'>
                <h4>Chỉnh sửa mục đích khóa học</h4>
        
                <div class='spacer'></div>
                <div class='form-group'>
                    <label for='purpose_content' class='form-label'>Nội dung yêu cầu </label>
                    <input id='purpose_content' name='purpose_content' required type='text' class='form-control' value='".$row['purpose_content']."'>
                </div>
        
                <div class='spacer'></div>
                <div class='form-group'>
                        <label for='purpose_course' class='form-label'>Khóa học</label>
                        <select name='purpose_course' id='purpose_course' class='select-control'>
                                <option style='font-size: 16px; color:#000;' disabled>----Chọn khóa học----</option>";
                                echo select_course();
                echo "</select>
                </div>
        
                <div class='form-button'>
                    <input type='submit' name='edit_purpose' class='form-btn save' value='Lưu'>
                    <a href='http://localhost/BeeEducation/Admin/index.php?setup&purpose'><input type='button' class='form-btn exit' value='Hủy'></a>
                </div>
                <a href='http://localhost/BeeEducation/Admin/index.php?setup&purpose'><i class='fas fa-times close'></i></a>
            </form>
            </div>";

            if($_SERVER['REQUEST_METHOD']=='POST'){
                //----Kiểm tra tên chủ đề
                if(isset($_POST['edit_purpose'])){
                    $purpose_content= trim($_POST['purpose_content']);
                    $purpose_course =  $_POST['purpose_course'];
                    if(empty($purpose_content)){
                        echo "<script>alert('Vui lòng nhập tên chủ đề!')</script>";
                        echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&purpose';</script>";
                    }
                }
                
                $edit_purpose = $con->prepare("UPDATE purpose SET purpose_content='$purpose_content', course_id='$purpose_course' WHERE purpose_id='$id'");
                if($edit_purpose->execute()) {
                    echo "<script>alert('Đã cập nhật thành công')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&purpose';</script>";
                    
                }else {
                    echo "<script>alert('Cập nhật thất bại. Vui lòng thử lại sau!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&purpose';</script>";
                }
            
            }
            
        }
    }

    // Thêm giới thiệu khóa học
    function add_intro() {
        //Kết nối csdl
        include("includes/database.php");
        //Kiểm tra POST có tồn tại
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //----Kiểm tra tên chủ đề
            if(isset($_POST['add_intro'])){
                $intro_content =  $_POST['content'];
                
                if(empty($intro_content)){
                    echo "<script>alert('Vui lòng nhập nội dung yêu cầu!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&intro';</script>";
                }
            }
       
            $add_intro = $con->prepare("INSERT INTO intro(intro_content, account_id) VALUES ('$intro_content', 1)");
            if($add_intro->execute()) {
                echo "<script>alert('Đã thêm thành công')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&intro';</script>";
                
            }else {
                echo "<script>alert('Thêm thất bại. Vui lòng thử lại sau!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&intro';</script>";
            }
            
        
        }
    }

    // Hiển thị nội dung giới thiệu
    function view_intro(){
        include("includes/database.php");

        $get_intro = $con->prepare("SELECT * FROM intro");
        $get_intro->setFetchMode(PDO:: FETCH_ASSOC);
        $get_intro->execute();

        while($row_intro = $get_intro->fetch()){

            echo "<tr>
            <td><textarea rows='5'>".$row_intro['intro_content']."</textarea></td>
            <td><a href='index.php?setup&intro&edit_intro=".$row_intro['intro_id']."'><i class='fas fa-edit'></i></a></td>
            <td><a href='index.php?setup&intro&del_intro=".$row_intro['intro_id']."' class='confirmDelete'><i class='fas fa-trash-alt'></i></a></td>
            <td>".$row_intro['intro_time']."</td>
        </tr> ";
        }


        //Xóa giới thiệu khóa học
        if(isset($_GET['del_intro'])){
            $id = $_GET['del_intro'];

            $del_intro=$con->prepare("DELETE FROM intro WHERE intro_id='$id'");
            
            if($del_intro->execute()){
                echo "<script>alert('Đã xóa thành công')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&intro';</script>";
            }else {
                echo "<script>alert('Xóa thất bại. Vui lòng thử lại sau!')</script>";
                echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&intro';</script>";
            }
        }
    }

    function edit_intro() {
        include("includes/database.php");

        if(isset($_GET['edit_intro'])) {
            $id=$_GET['edit_intro'];

            $get_intro=$con->prepare("SELECT * FROM intro WHERE intro_id='$id'");
            $get_intro->setFetchMode(PDO:: FETCH_ASSOC);
            $get_intro->execute();
            $row_intro=$get_intro->fetch();

            echo "<div class='form-container' style='top:60px'>
                        <form action='' method='POST' class='form' style='width:1000px' id='editIntro-form' enctype='multipart/form-data'>
                            <div class='spacer' style='margin-top: 50px;'></div>
                            <textarea name='content' id='content' placeholder='Đây là nội dung...' rows='10' cols='80'>".$row_intro['intro_content']."</textarea>
                            <div class='form-button'>
                                <input type='submit' name='edit_intro' class='form-btn save' value='Lưu'>
                                <a href='http://localhost/BeeEducation/Admin/index.php?setup&intro'><input type='button' class='form-btn exit' value='Hủy'></a>
                            </div>
                            <a href='http://localhost/BeeEducation/Admin/index.php?setup&intro'><i class='fas fa-times close'></i></a>
                        </form>
                    </div>";

            if($_SERVER['REQUEST_METHOD']=='POST'){
                //----Kiểm tra tên chủ đề
                if(isset($_POST['edit_intro'])){
                    $intro_content= $_POST['content'];
                }
                
                $edit_intro = $con->prepare("UPDATE intro SET intro_content='$intro_content', account_id=1 WHERE intro_id='$id'");
                if($edit_intro->execute()) {
                    echo "<script>alert('Đã cập nhật thành công')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&intro';</script>";
                    
                }else {
                    echo "<script>alert('Cập nhật thất bại. Vui lòng thử lại sau!')</script>";
                    echo "<script>location.href='http://localhost/BeeEducation/Admin/index.php?setup&intro';</script>";
                }
            
            }
            
        }
    }
    /**===================================== */


    /**==============THỐNG KÊ=============== */
    function countCoures(){
        include("includes/database.php");

        $get_course = $con->prepare("SELECT COUNT(*) as n FROM courses");
        $get_course->setFetchMode(PDO:: FETCH_ASSOC);
        $get_course->execute();
        $count = $get_course->fetch();
        return $count['n'];   
    }

    function countLessons(){
        include("includes/database.php");

        $get_lesson = $con->prepare("SELECT COUNT(*) as n FROM lessons");
        $get_lesson->setFetchMode(PDO:: FETCH_ASSOC);
        $get_lesson->execute();
        $count = $get_lesson->fetch();
        return $count['n'];   
    }

    function countAccounts(){
        include("includes/database.php");

        $get_acc = $con->prepare("SELECT COUNT(*) as n FROM accounts WHERE account_type='user'");
        $get_acc->setFetchMode(PDO:: FETCH_ASSOC);
        $get_acc->execute();
        $count = $get_acc->fetch();
        return $count['n'];   
    }

    function countBlogs(){
        include("includes/database.php");

        $get_blog = $con->prepare("SELECT COUNT(*) as n FROM blogs WHERE blog_status=1");
        $get_blog->setFetchMode(PDO:: FETCH_ASSOC);
        $get_blog->execute();
        $count = $get_blog->fetch();
        return $count['n'];   
    }

    function viewAccounts(){
        include("includes/database.php");

        $get_acc = $con->prepare("SELECT * FROM accounts WHERE account_type='user'");
        $get_acc->setFetchMode(PDO:: FETCH_ASSOC);
        $get_acc->execute();
        while($row = $get_acc->fetch()){
            echo " <li>
                        <img src='./img/accounts/".$row['account_image']."'>
                        <h4>".$row['account_name']."</h4>
                    </li>";
        }
         
    }

    function viewCourseDetail(){
        include("includes/database.php");

        $get_course = $con->prepare("SELECT s.course_name,SUM(l.lesson_duration) as sum, COUNT(*) as count FROM `courses` s JOIN `chapters` c ON s.course_id=c.course_id JOIN `lessons` l ON l.chapter_id=c.chapter_id GROUP BY c.course_id");
        $get_course->setFetchMode(PDO:: FETCH_ASSOC);
        $get_course->execute();
        while($row = $get_course->fetch()){
            echo "  <tr>
                        <td>".$row['course_name']."</td>
                        <td>".$row['count']." bài</td>
                        <td>".chang_time($row['sum'])."</td>
                    </tr>";
        }
         
    }

    /**===================================== */

?>




