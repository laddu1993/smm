<?php $user_level = array('0' => 'Admin', '1' => 'User', '2' => 'Sales' ); ?>
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
                    <h4 class="fontcolor-primary text-bold">Hi, <?php echo (!empty($this->session->userdata['full_name']) ? $this->session->userdata['full_name'] : '-'); ?> </h4>
                    <p>
                        Welcome to your account settings <br> kindly update your profile with relevant information. <br> <br> For any assistance kindly contact <span class="text-bold fontcolor-primary">help@fihd.in.</span>
                    </p>
                </div>
            </div>
            <div class="panels marginbtm-10">
                <div class="user-panel">
                    <h4 class="fontcolor-primary text-bold" style="margin-bottom: 25px;">Linked Mobile </h4>
                    <?php if(!empty($uniq_id) && !empty($mob_type)){ ?> <p> Type: <?php echo (!empty($mob_type) ? $mob_type : '-'); ?> <br> UDID: <?php echo (!empty($uniq_id) ? $uniq_id : '-'); ?> </p><?php }else{ ?>
                      <p class="mobile-text">Kindly Contact FiHD to link your Mobile </p>
                    <?php } if(!empty($uniq_id) && !empty($mob_type)){ ?>
                    <div class="float-right FiHD-secondary rev text-bold" > 
                      <small id="revoke">Revoke Access</small>
                      <small id="block">Block User</small>      
                    </div>
                    <?php } ?>    
                    <br>
                </div>
            </div>
        </div>

        <div class="col-lg-8 ">
         <!-- START radial charts-->
         <?php if (!empty($this->uri->segment(4)) == '1') { ?>
         <div class="alert alert-inverse" id="notification" style="background-color: #FD6705;border-color: #FD6705;color: #fff">
            <strong>Successfully</strong> Updated User..!!
         </div>
         <br>
         <?php } ?>
            <form action="<?= site_url('Users/update_user') ?>" name="update_user" method="post">
              <!-- User Profile  -->
              <div id="FiHD-setting-tab1" >
                <div class="setting">
                  <div class="row ">
                    <div class="settings">
                        <div class="col-lg-12">
                            <div class="user-panel-form">
                              <div class="forms">
                                 <input id="quantity" type="text" onkeypress="function(e)" name="full_name" placeholder="Full Name" value="<?php echo (!empty($full_name) ? $full_name : '-'); ?>" class="form-control"><span id="errmsg"></span>
                              </div>
                              <div class="forms">
                                 <input type="text" placeholder="Email ID" value="<?php echo (!empty($email_id) ? $email_id : '-'); ?>" class="form-control" id="email_address" size="35" maxlength="255">
                                <span id="email_errmsg"></span>
                              </div>
                              <div class="forms" style="position:relative">
                                 <input type="password" placeholder="Password" id="old_password" class="form-control" value="<?php echo (!empty($password) ? $password : '-'); ?>">
                                 <small class="change_password"  id="change_pass">Change Password</small >
                              </div>
                              <span id="password_strength"></span>
                              
                              <div class="change_password_input" id="change_pass_field" st>
                                <div class="forms">
                                  <input type="password" placeholder="New Password" name="new_password"  id="newpassword" class="form-control"><span id="passwordstrength"></span>
                                </div>
                                <div class="forms" >
                                   <input type="password" placeholder="Confirm New Password" name="confirm_password" id="cofpassword" class="form-control"><span id="passwordstrengths"></span>
                                </div>
                              </div>

                              <div class="forms">
                                <select name="status" id="user_err"  class="form-control">
                                    <option selected="true" disabled>Userstatus</option>
                                    <?php if ($status == 0) { ?>
                                    <option value="0" selected>Active</option>
                                    <option value="1">Inactive</option>
                                    <?php }else{ ?>
                                    <option value="1" selected>Inactive</option>
                                    <option value="0">Active</option>
                                    <?php } ?>
                                </select>
                                <span id="user_status"></span>
                              </div>

                              <div class="forms">
                                <select name="user_admin" id="user_err"  class="form-control">
                                    <option selected="true" disabled>Userstatus</option>
                                    <?php foreach ($user_level as $key => $value) { if($user_admin == $key){ ?>
                                    <option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
                                    <?php }else{ ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } } ?> 
                                </select>
                                <span id="user_status"></span>
                              </div>

                              <div class="forms">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-10">
                                  <div class="text-align">
                                    <input type="hidden" name="Usr_Id" value="<?php echo (!empty($id) ? $id : '-'); ?>">
                                    <button type="submit" class="btn  btn-color FiHD-secondarybg" id="btnSubmit" value="Validate">Update</button>
                                  </div>                                           
                                </div>
                              </div>
                            </div>
                            <!-- Change Password field -->
                        </div>         
                    </div>
                  </div>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>

</section>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>   
<script type="text/javascript">

  $('#quantity').keypress(function (e) {
  var regex = new RegExp("^[a-zA-Z ]*$");
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
var validateEmail = function(elementValue) {
  var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  return emailPattern.test(elementValue);
}

$('#email_address').keyup(function() {

  var value = $(this).val();
  var valid = validateEmail(value);

  if (!valid) {


      $(this).css('color', 'red');
      $('#email_errmsg').html(value +   "").show();

  } else {
    $("#email_errmsg").hide();


      $(this).css('color', '#000');

  }



});
</script>
<script type="text/javascript">
  $(function () {
      $("#txtPassword").bind("keyup", function () {
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

    $("form").submit(function( event ) {
         var old_password = $('#old_password').val();
         var newpassword = $('#newpassword').val();
         var cofpassword = $('#cofpassword').val();
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
         var user_err = $("#user_err").val();
          //alert(user_err);
         if (user_err== "" || user_err == null) {
            //If the "Please Select" option is selected display error.
            $('#user_status').css('color', 'red');
            $('#user_status').html("User Status is required").show();
            return false;
         }
         
   });

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
   setTimeout(function() {
       $('#notification').fadeOut('fast');
   }, 3000);
</script>