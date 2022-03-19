<div class="box-content">
    <div class="transfer" style="margin-right: 20px">
        <button class="box-transfer">
            <a href="index.php?setup&purpose">Mục đích</a>
        </button>
        <button class="box-transfer">
            <a href="index.php?setup&intro">Giới thiệu</a>
        </button>
    </div>

<?php 
    if(isset($_GET['purpose'])){
        include("./includes/purpose.php");
    }
    else if(isset($_GET['intro'])){
        include("./includes/intro.php");
    }else{
?>



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