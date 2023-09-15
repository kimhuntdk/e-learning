<!DOCTYPE html>
<html lang="en">

<!-- Head Start -->
<?php include('head.php')?>
<!-- Head End -->

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <?php include('Navbar.php')?>
    <!-- Navbar End -->

    <!-- Header Start -->

    <!-- Header End -->
    
    <br>
<br>
    <div class="cont">
        <div class="form sign-in">
            <form id="my-form" action="chek-login.php" method="post">
            <h2>Login to E-Learning </h2>
            <p style="text-align: center;">บัญชีใช้งานเดียวกันกับระบบ reg.msu.ac.th</p>
            <label>
                <span>Username</span>
                <input type="text" name="user" require />
            </label>
            <label>
                <span>Password</span>
                <input type="password" name="pass" require />
            </label>
            <label>
            <span>Status</span>
                    <select name="status" class="form-select" require>
                      <option value="0"></option>
                      <option value="1">Graduate Student</option>
                      <option value="2">Advisor</option>
                    </select>
                    </label>
            <input type="submit" name="submit" value="Sing In">
            </form>
        </div>

        <div class="sub-cont">
            <div class="img">
                <div class="img__text m--up">
                    <h3>Don't have an account? Please Sign up!<h3>
                </div>
                <div class="img__text m--in">
                
                    <h3>If you already has an account, just sign in.<h3>
                </div>
                <div class="img__btn">
                    <span class="m--up">Sign Up</span>
                    <span class="m--in">Sign In</span>
                </div>
            </div>
            <div class="form sign-up">
                <h2>Create your Account</h2>
                <label>
                    <span>ชื่อ</span>
                    <input type="text" />
                </label>
                <label>
                    <span>นามสกุล</span>
                    <input type="text" />
                </label>
                <label>
                    <span>Email</span>
                    <input type="email" />
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" />
                </label>
                <button type="button" class="submit">Sign Up</button>
                
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.img__btn').addEventListener('click', function() {
            document.querySelector('.cont').classList.toggle('s--signup');
        });
    </script>
  

    <!-- Footer Start -->
    <?php include('Footer.php')?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="Captcha-Plugin/src/jquery.captcha.basic.js"></script>
   <script type="text/javascript">
		$( document ).ready( function () {
      
     $('#my-form').captcha();
			
		} ); 
		
		
			</script>  
</body>

</html>