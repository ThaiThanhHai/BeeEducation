
<div class="content">
    <?php
        if(isset($_GET['courses'])){
            include("./courses.php");
        }
        else if(isset($_GET['lessons'])){
            include("./lesson.php");
        }
        else if(isset($_GET['accounts'])){
            include("./accounts.php");
        }
        else if(isset($_GET['chapters'])){
            include("./chapters.php");
        }
        else if(isset($_GET['blogs'])){
            include("./blogs.php");
        }
        else if(isset($_GET['setup'])){
            include("./setup.php");
        }
        else{
            include("./databoard.php"); 
        } 
    ?>
</div>