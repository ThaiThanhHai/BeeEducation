<?php  if(isset($_GET['edit_account'])){
    echo edit_account();
}else { ?>
<!-- form thêm dữ liệu -->
<div class="form-container" >
    <form method="POST" class="form" id="addAccount-form" enctype="multipart/form-data" onsubmit="return validateform()">
        <h4>Tạo tài khoản</h4>
   
        <div class="spacer"></div>
        <div class="form-group">
            <input type="text" id="account_name" name="account_name" class="form-control" required placeholder="Họ tên">
        </div>

        <div class="spacer"></div>
        <div class="form-group">
            <input type="email" id="account_email" name="account_email" required class="form-control" placeholder="Email">
        </div>

        <div class="spacer"></div>
        <div class="form-group">
            <input type="password" id="account_password" name="account_password" required class="form-control" placeholder="Mật khẩu">
        </div>

        <div class="spacer"></div>
        <div class="form-group">
            <input type="password" id="account_password1" name="account_password1" required class="form-control" placeholder="Nhập lại mật khẩu">
        </div>

        <div class="spacer"></div>
        <div class="form-group">
            <div class="box-file">
                <input type="file" id="account_image" name="account_image" hidden="hidden">
                <button type="button" id="custom-button">Chọn ảnh</button>
                <span id="custom-text">Không có tệp nào được chọn</span>
            </div>
        </div>

        <div class="spacer"></div>
        <div class="form-group">
            <div class="box-radio">
                <input type="radio" name="account_type" id="users" value="User" checked="checked">
                <label style="margin-right: 15px;" for="users">Học viên</label>
                <input type="radio" name="account_type" id="admin" value="Admin">
                <label style="margin-left: 15px;" for="admin">Quản trị viên</label>
            </div>
        </div>
        
        <div class="form-button" style="margin-top: 40px;">
            <input type="submit" name="add_account" class="form-btn save" value="Lưu">
            <input type="button" class="form-btn exit" value="Hủy">
        </div>
        <i class="fas fa-times close"></i>
    </form>
</div>



<div class="box-content">
    <div class="spacer"></div>    
    <h3>Quản lý tài khoản</h3>
    <div class="spacer"></div>
    <div class="add"><i class="fas fa-plus-circle"></i>Thêm</div>
    <div class="spacer"></div>
    <div class="account-data">
        <div class="table-box">
            <table cellpadding="10">
                <tr>
                    <th>STT</th> 
                    <th>Tên tài khoản</th>
                    <th>Email</th>
                    <th>Mật khẩu</th>
                    <th>Ảnh</th>
                    <th>Loại</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                    <th>Thời gian</th>
                </tr>
                <?php echo view_account(); ?>

            </table>
        </div>
    </div>
</div>

<?php echo add_account(); }?>


<script>
  
    function validateform() {
        let name = document.getElementById('account_name');
        let password1 = document.getElementById('account_password1');
        let password = document.getElementById('account_password');
        if (password.value.length < 5) {
            alert("Mật khẩu phải có ít nhất 5 kí tự");
            return false;
        }else if(password.value != password1.value){
            alert("Xác nhận mật khẩu không chính xác. Vui lòng kiểm tra lại!");
            return false;
        }else if(name.value.trim() == ""){
            alert("Vui lòng nhập tên tài khoản!");
            return false;
        }   
    }
    
</script>