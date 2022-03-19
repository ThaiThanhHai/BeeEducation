<?php 
    if(isset($_GET['edit_chapter'])) {
        echo edit_chapter();
    }else{ 
?>
<!-- form thêm dữ liệu -->
<div class="form-container">
    <form action="" method="POST" class="form" id="addChapter-form" enctype="multipart/form-data">
        <h4>Thêm chủ đề</h4>

        <div class="spacer"></div>
        <div class="form-group">
            <label for="chapter_name" class="form-label">Tên chủ đề</label>
            <input id="chapter_name" name="chapter_name" required type="text" class="form-control">
        </div>

        <div class="spacer"></div>
        <div class="form-group">
                <label for="chapter_name" class="form-label">Khóa học</label>
                <select name="chapter_course" id="chapter_course" class="select-control">
                        <option style="font-size: 16px; color:#000;" disabled>----Chọn khóa học----</option>
                        <?php echo select_course(); ?>
                </select>
        </div>

        <div class="form-button">
            <input type="submit" name="add_chapter" class="form-btn save" value="Lưu">
            <input type="button" class="form-btn exit" value="Hủy">
        </div>
        <i class="fas fa-times close"></i>
    </form>
</div>


<div class="box-content">
    <div class="spacer"></div>    
    <h3>Quản lý chủ đề khóa học</h3>
    <div class="spacer"></div>
    <div class="add"><i class="fas fa-plus-circle"></i>Thêm</div>
    <div class="spacer"></div>
    <div class="chapter-data">
        <div class="table-box">
            <table cellpadding="10">
                <tr>
                    <th>STT</th> 
                    <th>Tên chủ đề</th>
                    <th>Khóa học</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                    <th>Thời gian</th>
                </tr>
                <?php view_chapter(); ?>
                
            </table>
        </div>
    </div>
</div>


<?php echo add_chapter(); }?>