<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from themicon.co/theme/angle/v3.7.5/backend-jquery/app/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Oct 2017 05:54:47 GMT -->
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <title>ALTMARKIT FORGOT PASSWORD</title>
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="<?= site_url('cms-assets/css/font-awesome.min.css') ?>">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="<?= site_url('cms-assets/css/bootstrap.css') ?>" >
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="<?= site_url('cms-assets/css/main.css') ?>" >
</head>

<body >
   <div class="FiHD">
      <!-- START panel-->
            <div class="FiHD-Content">
              <div class="col-md-2">
                <div class="forgot-logo">
                  <img src="<?= site_url('cms-assets/img/invision-logo-white.png') ?>" alt="" class="img-responsive">
                </div>
              </div>
              <div class="col-md-10">
                <div class="forgot-login">
                   <span>Don't Have an account ?</span><a href="http://www.havock.org/contact" target="_blank" class="btn-color FiHD-primarybg ">Contact Us</a>
                </div>
              </div>
            </div>
            <div class="margin-50"></div>
            <div class="forgot">
               <h2 class="text-center">Forgot your password? </h2>
               <h4>Enter your email address below and we'll get you back on track.</h4>
               <div class="margin-50"></div>

               <span class="error FiHD-secondary"><p id="name_error"></p></span>
               <form onsubmit="return validateForm()" action="<?= site_url('Login/recover_password') ?>" method="post"  name="english_registration_form" id="english_registration_form" class="mb-lg">
                  <div class="form-group">
                     <input id="email" name="email" type="email" placeholder="Enter email"  autocomplete="off"  class="form-control">
                  </div>
                  <div class="margin-50"></div>
                  <div class="button">
                    <button type="submit" class="btn btn-color FiHD-primarybg">Request Reset Link</button><br>
                    <div class="margin-20"></div>
                    <a href="<?= site_url('/') ?>" class="FiHD-secondary">Back to Sign in</a>
                  </div>

               </form>
               
            </div>
         
   </div>
   <!-- =============== VENDOR SCRIPTS ===============-->
   <!-- MODERNIZR-->
   <script src="<?= site_url('cms-assets/vendor/jquery/dist/jquery.js') ?>"></script>
   <!-- BOOTSTRAP-->
   <script src="<?= site_url('cms-assets/vendor/bootstrap/dist/js/bootstrap.js') ?>"></script>
   
   <!--  End of Script-->

   <!-- script for Validation of the page -->
   <script>
      function validateForm() {
      var x = document.forms["english_registration_form"]["email"].value;
      if (x == null || x == "") {
          nameError = "Oops! That  is not valid.";
          document.getElementById("name_error").innerHTML = nameError; 
         
          return false;
      } 

      else {return true;}
      }
   </script>

   <script type="text/javascript">
      ("#btn")
   </script>

   <!-- End of script -->
</body>


<!-- Mirrored from themicon.co/theme/angle/v3.7.5/backend-jquery/app/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Oct 2017 05:54:47 GMT -->
</html>