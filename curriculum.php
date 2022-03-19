<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chương trình giảng dạy</title>
    <!-- google font cdn link -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- font anewesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include("./includes/header.php"); ?>

    <!-- CourseDetails Section Starts -->
    <section id="CourseDetails" class="CourseDetails">
        <div class="left">
            <?php echo view_course_name(); ?>
            <div class="topicList">
                <h3>Bạn sẽ học được gì</h3>
                <ul>
                    <?php echo select_purpose(); ?>
                </ul>
            </div>  
            <div class="Curriculum">
                <div class="headerSticky">
                    <div class="headerBlock">
                        <h3>Nội dung khóa học</h3>
                    </div>
                    <div class="subHeaderWrapper">
                        <ul>
                            <li>
                                <span><?php echo count_chapter(); ?></span> phần
                            </li>
                            <li>
                                <span><?php echo count_lesson(); ?></span> bài học
                            </li>
                            <li>
                                Thời lượng 
                                <span><?php echo count_time(); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="panelGroup">
                    <?php echo view_curriculum(); ?>
                </div>
            </div>
            <div class="request">
                <h3>Yêu cầu</h3>
                <ul>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Máy vi tính kết nối internet (Windows, Ubuntu hoặc MacOS)</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Ý thức tự học cao, trách nhiệm cao, kiên trì bền bỉ không ngại cái khó</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Không được nóng vội, bình tĩnh học, làm bài tập sau mỗi bài học</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Khi học nếu có khúc mắc hãy tham gia hỏi/đáp trên các diễn đàn về lập trình</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Bạn không cần biết gì hơn nữa, trong khóa học tôi sẽ chỉ cho bạn những gì bạn cần phải biết</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="right">
            <div class="video-intro">
                <iframe width="335" height="190" src="https://www.youtube.com/embed/f7L6lr6kU2o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <h5>Miễn phí</h5>
            <button class="learnNow btn"><a href="<?php echo 'lesson.php?course_id='.$_GET['course_id'];?>">Học ngay</a></button>
            <ul>
                <li>
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Trình độ cơ bản</span>
                </li>
                <li>
                    <i class="fas fa-film"></i>
                    <span>Tổng số <strong> <?php echo count_lesson(); ?></strong> bài học</span>
                </li>
                <li>
                    <i class="fas fa-clock"></i>
                    <span>Thời lượng <strong><?php count_time(); ?></strong></span>
                </li>
                <li>
                    <i class="fas fa-battery-full"></i>
                    <span>Học mọi lúc, mọi nơi</span>
                </li>
            </ul>
        </div>
    </section>

    <!-- CourseDetails Section Ends -->
   
    <?php include("./includes/footer.php") ?>

    <!-- jquery cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- custom js file link -->
    <script src="./js/main.js"></script>

</body>
</html>
