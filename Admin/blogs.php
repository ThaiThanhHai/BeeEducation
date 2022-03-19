<?php 
    if(isset($_GET['edit_blog'])) {
        echo edit_blog();
    }else if(isset($_GET['view_content'])){ 
?>
<div class="box-content">
<div class="spacer"></div>    
<h3>Quản lý bài giảng</h3>

<div class="spacer"></div>
<div class="blogs-data">
    <div class="table-box">
        <table cellpadding="10">
            <?php echo view_content(); ?>
        </table>
    </div>
</div>
</div>

<?php }else{ ?>


<div class="box-content">
    <div class="spacer"></div>    
    <h3>Quản lý bài viết</h3>
    <div class="spacer"></div>
    <div class="blogs-data">
        <div class="table-box">
            <table cellpadding="10">
                <tr>
                    <th>STT</th> 
                    <th>Tiêu đề</th>
                    <th>Ảnh</th>
                    <th>Duyệt</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                    <th>Xem nội dung</th>
                    <th>Thời gian</th>
                </tr>
                <?php echo view_blog(); ?>
            </table>
        </div>
    </div>
</div>

<?php }?>
<script src="plugins/ckeditor/ckeditor.js"></script>
<script src="plugins/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
   CKEDITOR.replace( 'content',
    {
    filebrowserBrowseUrl: 'plugins/ckfinder/ckfinder.html',
    filebrowserUploadUrl: 'plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
 });
</script>

<script>
    
//     document.querySelectorAll('.table-box tr td form .btn').forEach(btn => {
//         btn.addEventListener('click',function(){   
//             let title = document.querySelector('.table-box tr .title').innerHTML;
//             document.querySelector('.table-box tr td form .blog_title').value = title;
//             console.log(document.querySelector('.table-box tr td form .blog_title').value)
//     })
// })
    // let button = document.querySelector('.table-box tr td form .btn')
    // parent = button.parentNode
    // console.log(parent)
    // button.forEach(btn => {btn.addEventListener('click', function(){
    //     console.log(button.)
    // })})
        // let mainSrc = document.querySelector('.main-video .video .main').src;
        // document.querySelector('.comments .form-comment form .lesson_id').value = mainSrc;
        // console.log(document.querySelector('.comments .form-comment form .lesson_id').value)

</script>