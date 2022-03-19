 <!-- info section starts -->
 <section id="info" class="info">
        <h1 class="heading">
            <span>Thông tin cá nhân</span>
        </h1>

        <form method="POST" id="Form-Info" enctype="multipart/form-data" onsubmit="return validateform()">
            <div class="box">
                <label for="" class="form-label">Tên đăng nhập</label>
                <input type="text" value="<?php echo $_SESSION['account_name'] ?>" name="account_name" class="form-control">
            </div>
            <div class="box">
                <label for="" class="form-label">Email</label>
                <input type="email" value="<?php echo $_SESSION['account_email'] ?>" name="account_email" class="form-control">
            </div>
            <div class="box">
                <label for="" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" name="account_password">
            </div>
            <div class="box">
                <label for="" class="form-label">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" name="account_password1">
            </div>
            <div class="box">
                <label for="" class="form-label">Ảnh đại diện</label>
                <input type="file" class="form-control" name="account_image">
            </div>
            
            <input type="submit" name="edit_account" value="Cập nhật" class="btn" style="margin-left: 700px;">
        </form>

        <?php echo edit_account(); ?>
    </section>
    <!-- info section ends -->
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