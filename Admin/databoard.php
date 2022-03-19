<!-- card -->
<div class="cardBox">
    <div class="card">
        <div>
            <div class="number"><?php echo countCoures(); ?></div>
            <div class="cardName">Khóa học</div>
        </div>
        <div class="iconBx">
            <i class="fas fa-graduation-cap"></i>
        </div>
    </div>
    <div class="card">
        <div>
            <div class="number"><?php echo countLessons(); ?></div>
            <div class="cardName">Bài giảng</div>
        </div>
        <div class="iconBx">
            <i class="fas fa-laptop-code"></i>
        </div>
    </div>
    <div class="card">
        <div>
            <div class="number"><?php echo countAccounts(); ?></div>
            <div class="cardName">Học viên</div>
        </div>
        <div class="iconBx">
            <i class="fas fa-users"></i>
        </div>
    </div>
    <div class="card">
        <div>
            <div class="number"><?php echo countBlogs(); ?></div>
            <div class="cardName">Blogs</div>
        </div>
        <div class="iconBx">
            <i class="fas fa-newspaper"></i>
        </div>
    </div>

</div>

<!-- data list -->
<div class="details">
    <div class="recentCourses">
        <div class="cardHeader">
            <h2>Khóa học hiện tại</h2>
            <!-- <a href="#" class="btn">Xem tất cả</a> -->
        </div>
        <div class="table-box">
            <table>
                <tr>
                    <th>Khóa học</th>
                    <th>Số bài giảng</th>
                    <th>Tổng số giờ học</th>
                </tr>
                <?php echo viewCourseDetail(); ?>
            </table>
        </div>
    </div>

    <div class="recentUsers">
        <div class="cardHeader">
            <h2 style="text-align: center;">Học viên hiện tại</h2>
        </div>

        <div class="listUsers">
            <?php echo viewAccounts(); ?>    
        </div>
    </div>
</div>