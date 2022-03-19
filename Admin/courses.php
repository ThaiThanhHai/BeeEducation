<?php 
    if(isset($_GET['edit_course'])) {
        echo edit_course();
    }else if(isset($_GET['view_desrcibe'])){ 
?>
<div class="box-content">
<div class="spacer"></div>    
<h3>Quản lý bài giảng</h3>

<div class="spacer"></div>
<div class="lesson-data">
    <div class="table-box">
        <table cellpadding="10">
            <tr>
                <th style="height: 30px; width:10%; padding-left: 10px">Khóa học</th>
                <th style="height: 30px; padding-right: 10px">Mô tả khóa học</th>
            </tr>
            <?php echo view_desrcibe(); ?>
        </table>
    </div>
</div>
</div>

<?php }else{ ?>

<div class="box-content">
    <div class="spacer"></div>    
    <h3>Quản lý khóa học</h3>
    <div class="spacer"></div>
    <div class="add"><i class="fas fa-plus-circle"></i>Thêm</div>
    <div class="spacer"></div>
    <div class="course-data">
        <div class="table-box">
            <table cellpadding="10">
                <tr>
                    <th>STT</th> 
                    <th>Tên khóa học</th>
                    <th>Ảnh</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                    <th>Xem mô tả</th>
                    <th>Thời gian</th>
                </tr>
                <?php echo view_course(); ?>
                
            </table>
        </div>
    </div>
</div>

<!-- form thêm dữ liệu -->
<div class="form-container">
    <form action="" method="POST" class="form" id="addCourse-form" enctype="multipart/form-data">
        <h4>Thêm khóa học</h4>

        <div class="spacer"></div>

        <div class="form-group">
            <label for="course_name" class="form-label">Tên khóa học</label>
            <input id="course_name" name="course_name" required type="text" placeholder="VD: Học lập trình PHP" class="form-control">
            <span class="form-message"></span>
        </div>
        <div class="spacer"></div>
        <div class="form-group">
            <label for="course_image" class="form-label">Ảnh</label>
            <input id="course_image" name="course_image" required type="file">
            <span class="form-message"></span>
        </div>

        <div class="spacer"></div>
        <div class="form-group">
            <label for="course_desrcibe" class="form-label">Mô tả khóa học</label>
            <textarea name="course_desrcibe" id="course_desrcibe" cols="20" rows="4"></textarea>
            <span class="form-message"></span>
        </div>

        <div class="form-button">
            <input type="submit" name="add_course" class="form-btn save" value="Lưu">
            <input type="button" class="form-btn exit" value="Hủy">
        </div>
        <i class="fas fa-times close"></i>
    </form>
</div>

<?php echo add_course(); } ?>

