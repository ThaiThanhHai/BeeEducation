<!-- review section starts -->
<section id="review" class="review">
        <h1 class="heading">
            <span>Nhận xét khóa học</span>
        </h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <textarea name="review-content" class="box" placeholder="Nhận xét của bạn..." cols="30" rows="10"></textarea>
            <input type="submit" name="add_reivew" value="Nhận xét" class="btn" style="margin-left: 500px;">
        </form>
</section>
<!-- review section ends -->
<?php echo add_review(); ?>