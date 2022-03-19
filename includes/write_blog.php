    <!-- blogs section starts -->
    <section id="blogs" class="blogs">
        <h1 class="heading">
            <span>Viết Blogs</span> 
        </h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-control">
                <input type="text" placeholder="Tiêu đề" name="blog-title">      
                <input type="file" name="blog-imgae">
            </div>    
            <textarea name="content" class="form-control" id="content" cols="30" rows="10" ></textarea>
            <input type="submit" name="add_blog" value="Chia sẻ" class="btn" style="margin-left: 800px;">
        </form>
    </section>
    <!-- blogs section ends -->

    <?php echo add_blog(); ?>

