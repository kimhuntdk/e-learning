<?php
session_start();
?>
   <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <img width="140" height="80" class="vc_single_image-img" src="https://grad.msu.ac.th/th/wp-content/uploads/2022/11/cropped-308991677_648282600172299_4337174340948988668_n-e1671438758134.png"  alt="logo">
            <!-- <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>E-Learning</h2> -->
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link"><b>Home</b></a>
                <a href="courses.php" class="nav-item nav-link"><B>Courses</B></a>
                <!-- <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown"><B>Pages</B></a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="team.php" class="dropdown-item">Our Team</a>
                        <a href="testimonial.php" class="dropdown-item ">Testimonial</a>
                        <a href="404.php" class="dropdown-item">404 Page</a>
                    </div>
                </div> -->
                <a href="contact.php" class="nav-item nav-link"><B>Contact</B></a>
                <a href="about.php" class="nav-item nav-link"><B>About</B></a>
                <?php 
                    if(isset($_SESSION['SES_USER_LER'])){
                ?>
                <a href="logout.php" class="nav-item nav-link"><B>Logout</B></a>
                <?php }else { ?>
                <a href="login.php" class="nav-item nav-link"><B>Login</B></a>
              <?php  } ?>
            </div> 
            <!-- <a href="login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login<i class="fa fa-arrow-right ms-3"></i></a> -->
        </div>
    </nav>
    <!-- Navbar End -->