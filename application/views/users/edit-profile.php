<!-- Main section-->
<section>
  <!-- Page content-->
  <div class="content-wrapper">
    
    <!-- START radial charts-->
    <div class="row ">

       <div class="col-lg-4 ">
          <!-- START widget-->
          <div class="panels marginbtm-10">
            <div class="main-heading">
              <h4 class="fontcolor-primary text-bold">Hi, <?php echo (!empty($full_name) ? $full_name : '-'); ?> </h4 >
                <p>
                  Welcome to your account settings <br>
                  kindly update your profile with relevant information. <br> <br>
                  For any assistance kindly contact <span class="text-bold fontcolor-primary">help@fihd.in.</span>
                </p>                 
            </div>  
          </div>

        <div class="panels marginbtm-10">
            <div class="user-panel">
              <h4 class="fontcolor-primary text-bold " style="margin-bottom: 25px;">Subscribed Products </h4 >
                <div class="FiHD-products">
                  <div class="FiHD-Cms" style>  
                    <div class="product-unselected"></div>
                    <span>CMS</span>
                  </div>
                  <div class="FiHD-Cms">  
                    <div class="product-selected"></div>
                    <span>Marketing</span>
                  </div>
                  <div class="FiHD-Cms">  
                    <div class="product-unselected"></div>
                    <span>Mailer</span>
                  </div>
                  <div class="FiHD-Cms">  
                    <div class="product-unselected"></div>
                    <span>Team</span>
                  </div>
                </div>
                            
            </div>  
        </div>

          <!-- <div class="panels marginbtm-10">
            <div class="user-panel">
              <h4 class="fontcolor-primary text-bold" style="margin-bottom: 25px;">Linked Mobile </h4 >
                <?php if(!empty($mob_type) && !empty($uniq_id)){ ?>
                <p>
                  Type: <?php echo (!empty($mob_type) ? $mob_type : '-'); ?> <br>
                  UDID: <?php echo (!empty($uniq_id) ? $uniq_id : '-'); ?>
                </p>  
                <?php }else{ ?>
                <p class="mobile-text">Kindly Contact FiHD to link your Mobile </p>
                <?php } ?>               
            </div>  
          </div> -->
        </div>
      
        <div class="col-lg-8 ">
          <!-- START radial charts-->
          <form method="post" action="<?= site_url('Users/edit_profile') ?>">
            
            <!-- User Profile  -->
            <div id="FiHD-setting-tab1" >
              <?php if ($this->session->flashdata('message')) { ?>
                  <div class="text-center">
                    <span style="background:#759675; padding:5px; color:#fff; width:297px;"><?php echo $this->session->flashdata('message'); ?></span>
                  </div>
              <?php } ?>
              <div class="setting">
                <div class="row ">
                    <div class="settings">
                      <div class="col-lg-12">

                          <div class="user-panel-form">                        
                              
                            <div class="forms">
                              <input type="text" placeholder="Company Name" class="form-control" value="<?php echo (!empty($company_name) ? $company_name : '-'); ?>" readonly>
                                    <input type="hidden" name="Usr_Id" value="<?php echo (isset($_SESSION['marketing_Usr_Id']) ? $_SESSION['marketing_Usr_Id'] : '-'); ?>">
                              </div>

                              <div class="forms">
                              <input type="email" placeholder="Email ID" class="form-control" value="<?php echo (!empty($email_id) ? $email_id : '-'); ?>" readonly>
                              </div>

                              <div class="forms" style="position:relative;">
                              <input type="password" placeholder="Password" class="form-control" id="old_password" name="pass" value="<?php echo (!empty($password) ? $password : '-'); ?>">
                                <small class="change_password" id="change_pass">Change Password</small >
                              </div>
                              <span id="password_strength"></span>

                              <!-- Change Password field -->
                              <div class="change_password_input" id="change_pass_field">
                                   <div class="forms">
                                   <input type="password" placeholder="New Password" name="new_password" id="newpassword" class="form-control">
                                   </div> 
                                   <span id="passwordstrength"></span>
                                   <div class="forms" >
                                   <input type="password" placeholder="Confirm New Password" name="confirm_password" id="cofpassword" class="form-control">
                                   </div>
                                 <span id="passwordstrengths"></span>
                              </div>                     
                          </div> 
                          
                          <!-- END -->
                      </div>
                      
                    </div>
                </div>
              </div>

              <div class="bg-color">
                <div class="row">
                  <div class="col-lg-12 ">     
                       <div class="user-panel-form"> 
                        <div class="forms">
                        <input type="text" placeholder="Profile Name" class="form-control" name="full_name" value="<?php echo (!empty($full_name) ? $full_name : '-'); ?>">
                        </div>
                      </div>                                                                        
                  </div>
                </div>
              </div>

              <div class="setting">                                                
                    
                <div class="text-align">
                  <button type="submit" class="btn btn-color FiHD-secondarybg"> Update</button>
                </div>                                           
               
              </div>
            </div>

            <!-- End of User Profile -->

            

          </form>
          <!-- END -->
        </div>
    </div>
  </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>   
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
  $('#quantity').keypress(function (e) {
  var regex = new RegExp("^[a-zA-Z]+$");
  var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
  if (regex.test(str)) {
      $("#errmsg").hide();
      return true;
  }
  else
  {
  $("#errmsg").html("Alphabets only").show();
         return false;
  }
});
 </script>
 <script type="text/javascript">
     $(function () {
         $("#old_password").bind("keyup", function () {
             //TextBox left blank.
             if ($(this).val().length == 0) {
                 $("#password_strength").html("");
                 return;
             }
  
             //Regular Expressions.
             var regex = new Array();
             regex.push("[A-Z]"); //Uppercase Alphabet.
             regex.push("[a-z]"); //Lowercase Alphabet.
             regex.push("[0-9]"); //Digit.
             regex.push("[$@$!%*#?&]"); //Special Character.
  
             var passed = 0;
  
             //Validate for each Regular Expression.
             for (var i = 0; i < regex.length; i++) {
                 if (new RegExp(regex[i]).test($(this).val())) {
                     passed++;
                 }
             }
  
  
             //Validate for length of Password.
             if (passed > 2 && $(this).val().length > 8) {
                 passed++;
             }
  
             //Display status.
             var color = "";
             var strength = "";
             switch (passed) {
                 case 0:
                 case 1:
                     strength = "Weak";
                     color = "red";
                     break;
                 case 2:
                     strength = "Good";
                     color = "darkorange";
                     break;
                 case 3:
                 case 4:
                     strength = "Strong";
                     color = "green";
                     break;
                 case 5:
                     strength = "Very Strong";
                     color = "darkgreen";
                     break;
             }
             $("#password_strength").html(strength);
             $("#password_strength").css("color", color);
         });
     });
 </script>
 <script type="text/javascript">
     $(function () {
         $("#btnSubmit").click(function () {
             var user_err = $("#user_err").val();
             //alert(user_err);
             if (user_err== "" || user_err == null) {
                 //If the "Please Select" option is selected display error.
                 alert("Please select Userstatus!");
                 return false;
             }
             return true;
         });
     });
 </script>
 <script type="text/javascript">
     $(function () {
         $("#newpassword").bind("keyup", function () {
             //TextBox left blank.
             if ($(this).val().length == 0) {
                 $("#passwordstrength").html("");
                 return;
             }
  
             //Regular Expressions.
             var regex = new Array();
             regex.push("[A-Z]"); //Uppercase Alphabet.
             regex.push("[a-z]"); //Lowercase Alphabet.
             regex.push("[0-9]"); //Digit.
             regex.push("[$@$!%*#?&]"); //Special Character.
  
             var passed = 0;
  
             //Validate for each Regular Expression.
             for (var i = 0; i < regex.length; i++) {
                 if (new RegExp(regex[i]).test($(this).val())) {
                     passed++;
                 }
             }
  
  
             //Validate for length of Password.
             if (passed > 2 && $(this).val().length > 8) {
                 passed++;
             }
  
             //Display status.
             var color = "";
             var strength = "";
             switch (passed) {
                 case 0:
                 case 1:
                     strength = "Weak";
                     color = "red";
                     break;
                 case 2:
                     strength = "Good";
                     color = "darkorange";
                     break;
                 case 3:
                 case 4:
                     strength = "Strong";
                     color = "green";
                     break;
                 case 5:
                     strength = "Very Strong";
                     color = "darkgreen";
                     break;
             }
             $("#passwordstrength").html(strength);
             $("#passwordstrength").css("color", color);
         });
     });
 </script>

       <script type="text/javascript">
          $('#change_pass_field').css('display','none');
          $('#change_pass').click(function(){
           $('#change_pass_field').toggle();
           $('.change_password').toggle();
          })
       </script>
       <script type="text/javascript">
     $(function () {
         $("#cofpassword").keyup(function () {
             var password = $("#newpassword").val();
             var confirmPassword = $("#cofpassword").val();

             if (password != confirmPassword) {
               console.log(password);
              console.log(confirmPassword);
                 $('#passwordstrengths').css('color', 'red');
                 $('#passwordstrengths').html("New Password & Confirm Password does not match").show();
                
                
             }
             else
         {
           $('#passwordstrengths').css('color', 'green');
         $('#passwordstrengths').html("password matched").show();
                return false;
         }
         });
     });
 </script>
<script type="text/javascript">
   $('#change_pass_field').css('display','none');
   $('#change_pass').click(function(){
    $('#change_pass_field').css('display','block');
    $('#old_password').val(''); 
   })

   $("form").submit(function( event ) {
         var old_password = $('#old_password').val();
         var newpassword = $('#newpassword').val();
         var cofpassword = $('#cofpassword').val();
         if (old_password == '') {
            $('#password_strength').css('color', 'red');
            $('#password_strength').html("Old Password is required").show();
            return false;
         }
         if (old_password != '<?php echo (!empty($password) ? $password : '-'); ?>') {
            $('#password_strength').css('color', 'red');
            $('#password_strength').html("Old Password Not matched").show();
            return false;
         }
         if (newpassword != '' || cofpassword != '') {
            if (newpassword != cofpassword) {
               $('#passwordstrengths').css('color', 'red');
               $('#passwordstrengths').html("New Password & Confirm Password does not match").show();
               return false;
            }
         }
         
   });
</script>
<script type="text/javascript">
 
   setTimeout(function() {
       $('#notification').fadeOut('fast');
   }, 3000);
</script>