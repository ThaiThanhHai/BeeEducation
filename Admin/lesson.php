<?php 
        if(isset($_GET['edit_lesson'])) {
            echo edit_lesson();
        }else if(isset($_GET['add_lesson'])){ 
    ?>

<!-- form thêm dữ liệu -->
<div class="form-container" style="top: 60px;">
    <form method="POST" class="form" id="addLessons-form" enctype="multipart/form-data">
        <h4>Thêm bài giảng vào khóa học</h4>
   
        <div class="spacer"></div>
        <div class="form-group">
            <label for="lesson_title" class="form-label">Tiêu đề</label>
            <input type="text" id="lesson_title" name="lesson_title" required class="form-control">
        </div>

        <div class="spacer"></div>
        <div class="form-group">
            <label for="lesson_link" class="form-label">Link video</label>
            <input type="url" id="lesson_link" name="lesson_link" required class="form-control">
        </div>

        <div class="spacer"></div>
        <div class="form-group">
                <select name="lesson_chapter" id="lesson_chapter" class="select-control">
                        <option style="font-size: 16px; color:#000;" disabled>----Chọn chủ đề khóa học----</option>
                        <?php echo select_course_chapter(); ?>
                </select>
        </div>

        <div class="spacer"></div>
        <div class="form-group">
            <label for="lesson_desrcibe" class="form-label">Mô tả</label>
            <textarea name="lesson_desrcibe" id="lesson_desrcibe" cols="20" rows="4"></textarea>
            <span class="form-message"></span>
        </div>
        
        <div class="form-button">
            <input type="submit" name="add_lesson" class="form-btn save" value="Lưu">
            <a href="index.php?lessons"><input type="button" class="form-btn exit" value="Hủy"></a>
        </div>
        <a href="index.php?lessons"><i class="fas fa-times close"></i></a>
    </form>
</div>

<?php echo add_lesson();  }else if(isset($_GET['view_detail'])){ ?>
<div class="box-content">
    <div class="spacer"></div>    
    <h3>Quản lý bài giảng</h3>
   
    <div class="spacer"></div>
    <div class="lesson-data">
        <div class="table-box">
            <table cellpadding="10">
                <tr>
                    <th style="height: 30px; width:20%;">Bài giảng</th>
                    <th style="height: 30px; width:15%;">Link</th>
                    <th style="height: 30px; width:42%;">Mô tả</th>
                    <th style="height: 30px; width:10%;">Thời lượng</th>
                </tr>
                <?php echo view_detail(); ?>
            </table>
        </div>
    </div>
</div>

    


<?php }else{ ?>

<div class="box-content">
    <div class="spacer"></div>    
    <h3>Quản lý bài giảng</h3>
    <div class="spacer"></div>
    <div class="add_lesson"><a href=""><i class="fas fa-plus-circle"></i>Thêm</a></div>
    <div class="select_courses">
        <select onchange="validateSelectBox(this)" name="lesson_course" id="lesson_course" class="select-control">
                <option class="selected">Chọn khóa học</option>
                <?php echo select_course(); ?>  
        </select>
    </div>
    <div class="spacer"></div>
    <div class="lesson-data">
        <div class="table-box">
            <table cellpadding="10">
                <tr>
                    <th>STT</th> 
                    <th>Tiêu đề</th>
                    <th>Chủ đề</th>
                    <th>Khóa học</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                    <th>Chi tiết</th>
                    <th>Thời gian</th>
                </tr>
                <?php echo view_lesson(); ?>      
            </table>
        </div>
    </div>
</div>

<?php }?>


<script>
    function validateSelectBox(obj){
        let add_lesson = document.querySelector(".box-content .add_lesson a");
            
        options = obj.children;
        for (var i = 1; i < options.length; i++){
            if(options[i].selected){
                console.log(options[i].value);
                add_lesson.href = 'index.php?lessons&add_lesson=' + options[i].value
                console.log(add_lesson.href);
                break;
            }
        }
    }

</script>