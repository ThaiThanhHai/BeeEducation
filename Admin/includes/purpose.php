<?php 
    if(isset($_GET['edit_purpose'])) {
        echo edit_purpose();
    }else{ 
?>


<h3>Mục đích khóa học</h3>
<div class="spacer"></div>
<div class="add"><i class="fas fa-plus-circle"></i>Thêm</div>
<div class="spacer"></div>

<div class="purpose-data">
    <div class="table-box">
        <table cellpadding="10">
            <tr>
                <th>STT</th> 
                <th>Nội dung</th>
                <th>Khóa học</th>
                <th>Sửa</th>
                <th>Xóa</th>
                <th>Thời gian</th>
            </tr>        
            <?php echo view_purpose(); ?>  
        </table>
    </div>
</div>



<!-- form thêm dữ liệu -->
<div class="form-container">
    <form action="" method="POST" class="form" id="addPurpose-form" enctype="multipart/form-data">
        <h4>Thêm mục đích khóa học</h4>

        <div class="spacer"></div>

        <div class="spacer"></div>
        <div class="form-group">
            <label for="purpose_content" class="form-label">Mục đích khóa học </label>
            <input id="purpose_content" name="purpose_content" required type="text" class="form-control">
        </div>

        <div class="spacer"></div>
        <div class="form-group">
                <label for="purpose_course" class="form-label">Khóa học</label>
                <select name="purpose_course" id="purpose_course" class="select-control">
                        <option style="font-size: 16px; color:#000;" disabled>----Chọn khóa học----</option>
                        <?php echo select_course(); ?>
                </select>
        </div>
        <div class="form-button">
            <input type="submit" name="add_purpose" class="form-btn save" value="Lưu">
            <input type="button" class="form-btn exit" value="Hủy">
        </div>
        <i class="fas fa-times close"></i>
    </form>
</div>

<?php echo add_purpose(); }?>

</div>