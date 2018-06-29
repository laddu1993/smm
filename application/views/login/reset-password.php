<!DOCTYPE html>
<html lang="en">
<?php $user_id = $this->input->get('udid'); ?>

<!-- Mirrored from themicon.co/theme/angle/v3.7.5/backend-jquery/app/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Oct 2017 05:54:47 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>FiHD</title>
    <!-- =============== VENDOR STYLES ===============-->
    <!-- FONT AWESOME-->
    <link rel="stylesheet" href="<?= site_url('cms-assets/css/font-awesome.min.css') ?>">
    <!-- =============== BOOTSTRAP STYLES ===============-->
    <link rel="stylesheet" href="<?= site_url('cms-assets/css/bootstrap.css') ?>">
    <!-- =============== APP STYLES ===============-->
    <link rel="stylesheet" href="<?= site_url('cms-assets/css/main.css') ?>">
</head>

<body>
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

                </div>
            </div>
        </div>
        <div class="margin-50"></div>
        <div class="forgot">
          <h2 class="text-center">Please Enter Your New Password </h2>
          <div class="margin-50"></div>

          <span class="error FiHD-secondary"><p id="name_error"></p></span>
          <form onsubmit="return validateForm()" method="post" name="english_registration_form" id="english_registration_form" class="mb-lg" action="<?= site_url('Admin/reset_password') ?>">
              <div class="form-group">
                  <input id="email1" name="pass" type="password" placeholder="Enter New Password" autocomplete="off" class="form-control">
              </div>
              <div class="margin-50"></div>
              <div class="form-group">
                  <input id="cemail" name="compass" type="password" placeholder="Confirm Password" autocomplete="off" class="form-control">
                  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
              </div>
              <div class="margin-50"></div>
              <div class="button">
                  <button type="submit" class="btn btn-color FiHD-primarybg">Set New Password</button><br>
                  <div class="margin-20"></div>
                  <a href="<?= site_url('Admin/index') ?>" class="FiHD-secondary">Back to Sign in</a>
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
            var x = document.forms["english_registration_form"]["email1"].value;
            var y = document.forms["english_registration_form"]["cemail"].value;

            if (x == null || x == "" && y == null || y == "") {
                nameError = "Oops! That  is not valid.";
                document.getElementById("name_error").innerHTML = nameError;

                return false;
            } 
            else if(x != y){
              nameError="Oops! Your passwords do not match.";
              document.getElementById("name_error").innerHTML = nameError;

              return false;
            }

            else{
                return true;
            }
        }
    </script>
    <!-- End of script -->
</body>

</html>