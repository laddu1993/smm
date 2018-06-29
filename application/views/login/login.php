<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from themicon.co/theme/angle/v3.7.5/backend-jquery/app/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Oct 2017 05:54:47 GMT -->
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <title>ALTMARKIT - SOCIAL PLATFORM</title>
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="<?= site_url('cms-assets/css/font-awesome.min.css') ?>">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="<?= site_url('cms-assets/css/bootstrap.css') ?>" >
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="<?= site_url('cms-assets/css/main.css') ?>" >
</head>

<body style="overflow:hidden;">
   <div class="FiHD">
      <!-- START panel-->         
         
         <div class="col-md-4 col-lg-4 hidden-xs hidden-sm login-height" style="padding:0;">
            <div class="FiHDbg">
              <img src="<?= site_url('cms-assets/img/login.jpg') ?>" alt="" class="img-responsive">
               <div class="FiHD-Content">
                  <div class="logo1">
                     <img src="<?= site_url('cms-assets/img/alt_logo.png') ?>" alt="" class="img-responsive">
                  </div>
                  <div class="content">
                    <h5 style="visibility: hidden;">Alt CMS</h5>
                     <h4 style="visibility: hidden;">YOUR UNIFIED, SCALABLE WORKFLOW—ALL IN ONE PLACE</h4> 
                     <a href="#" class="btn-login">Learn More</a>
                  </div>
               </div>
            </div>
         </div>
         <div class=" col-md-8 col-lg-8 login-height">
            <div class="login-contact">
               <span>Don't Have an account ?</span><a href="#" target="_blank" class="btn-color FiHD-secondarybg">Contact Us</a>
            </div>
            <div class="col-md-6 col-lg-6 col-md-offet-2 col-lg-offset-2 login-form">
               <h4 class="">SIGN IN TO <span class="FiHD-secondary">ALT SOCIAL.</span></h4>
               
               <div class="margin-50"></div>
               <span class="error FiHD-secondary">
                <?php if ($this->session->flashdata('message')) { ?>
                 <p id="name_error" style="background:#f05050; padding:5px; color:#fff; width:297px;"><?php echo $this->session->flashdata('message'); ?></p> <br/>
                <?php }else{ ?>
                 <p id="name_error"> </p>
                <?php } ?>
               <!-- <div class="margin-50"></div> -->
               <form onsubmit="return validateForm()" action="<?= site_url('Login/login_check') ?>" method="post"  name="english_registration_form" id="altcms_login_form" class="mb-lg">
                  <div class="form-group positionrelative">
                     <input id="email" name="email" type="email" placeholder="Enter email"  autocomplete="off"  class="form-control">
                     
                     <span class="fa fa-envelope icons form-icon-1 FiHD-primary" ></span>
                  </div>
                  <div class="form-group positionrelative">
                     <input id="password-field" name="password" type="password" placeholder="Password"  class="form-control">
                      
                     <span toggle="#password-field" class="fa fa-fw fa-eye field-icon icons form-icon-2 FiHD-primary toggle-password"></span>
                  </div>
                  <div class="clearfix">
                     <div class="pull-right FiHD-secondary" style="margin:10px 0px;"><a href="<?= site_url('Login/recover_password') ?>" class="text-muted">Forgot your password?</a>
                     </div>
                  </div>
                  <div class="button">
                     <button type="submit" class="btn btn-color FiHD-secondarybg">Login</button>
                  </div>
               </form>
               
            </div>
         </div>
   </div>
   <!-- =============== VENDOR SCRIPTS ===============-->
   <!-- MODERNIZR-->
   <script src="<?= site_url('cms-assets/vendor/jquery/dist/jquery.js') ?>"></script>
   <!-- BOOTSTRAP-->
   <script src="<?= site_url('cms-assets/vendor/bootstrap/dist/js/bootstrap.js') ?>"></script>
   
   <!-- Script to Show the Password entered -->
   <script type="text/javascript">
      $(".toggle-password").click(function() {

     $(this).toggleClass("fa-eye fa-eye-slash");
     var input = $($(this).attr("toggle"));

     if (input.attr("type") == "password") {
       input.attr("type", "text");

     } else {
       input.attr("type", "password");
     }
   });
   </script>

   <!--  End of Script-->

   <!-- script for Validation of the page -->
   <script>
      function validateForm() {
      var x = document.forms["altcms_login_form"]["email"].value;
      var y = document.forms["altcms_login_form"]["password-field"].value;


      if (x == null || x == "" && y==null || y=="") {
      nameError = "Oops! That email / password combination is not valid.";
      document.getElementById("name_error").innerHTML = nameError; 
      return false;
      }else{
        document.getElementById("altcms_login_form").submit();
      }
    }
   </script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript">
      <?php if ($this->uri->segment(3) == 'reset') { ?>
      swal({
        title: "Successfully Changed Your Password!",
        text: "You may login now!",
        icon: "success",
        button: "Close!",
      });
      <?php } ?>
  </script>
   

   
   <!-- End of script -->
</body>


<!-- Mirrored from themicon.co/theme/angle/v3.7.5/backend-jquery/app/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Oct 2017 05:54:47 GMT -->
</html>