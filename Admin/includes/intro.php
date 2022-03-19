<?php 
    if(isset($_GET['edit_intro'])) {
        echo edit_intro();
    }else{ 
?>
<h3>Giới thiệu khóa học</h3>
<div class="form-container">
    <form action="" method="POST" class="form" style="width:1000px" id="addIntro-form" enctype="multipart/form-data">
        <div class="spacer" style="margin-top: 50px;"></div>
        <textarea name="content" id="content" placeholder="Đây là nội dung..." rows="10" cols="80"></textarea>
        <div class="form-button">
            <input type="submit" name="add_intro" class="form-btn save" value="Lưu">
            <input type="button" class="form-btn exit" value="Hủy">
        </div>
        <i class="fas fa-times close"></i>
    </form>
</div>



<div class="spacer"></div>
<div class="add"><i class="fas fa-plus-circle"></i>Thêm</div>
<div class="spacer"></div>

<div class="intro-data">
    <div class="table-box">
        <table cellpadding="10">
            <tr>
                <th>Nội dung</th>
                <th>Sửa</th>
                <th>Xóa</th>
                <th>Thời gian</th>
            </tr>        
            <?php echo view_intro(); ?>
        </table>
    </div>
</div>

<?php echo add_intro();}?>
</div>