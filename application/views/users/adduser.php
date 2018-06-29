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
                  <h4 class="fontcolor-primary text-bold">Hi, <?php echo (!empty($this->session->userdata['full_name']) ? $this->session->userdata['full_name'] : '-'); ?> </h4 >
                  <p>
                     Welcome to your account settings <br>
                     kindly update your profile with relevant information. <br> <br>
                     For any assistance kindly contact <span class="text-bold fontcolor-primary">help@fihd.in.</span>
                  </p>
               </div>
            </div>
         </div>
         <div class="col-lg-8 ">
        <?php if (!empty($this->uri->segment(3)) == '1') { ?>
            <div class="alert alert-inverse" id="notification" style="background-color: #FD6705;border-color: #FD6705;color: #fff">
               <strong>Username</strong> Already Exists..!!
            </div>
            <br>
        <?php } ?>
            <!-- START radial charts-->
            <form action="<?= site_url('Users/adduser') ?>" name="add_user" method="post">
               <!-- User Profile  -->
               <div id="FiHD-setting-tab1" >
                  <div class="setting">
                     <div class="row ">
                        <div class="settings">
                           <div class="col-lg-12">
                              <div class="user-panel-form">
                                 <div class="forms">
                                    <input type="text" onkeypress="function(e)" name="full_name" id="full_name" placeholder="Full Name" class="form-control"><span id="errmsg"></span>
                                 </div>
                                 <div class="forms">
                                    <input type="text" name="email_id" placeholder="Email ID" class="form-control" id="email_address"  size="35" maxlength="255"><span id="email_errmsg"></span>
                                 </div>
                                 <div class="forms">
                                    <input type="password" placeholder="Password" name="new_password" id="txtPassword" class="form-control"><span id="password_strength"></span>
                                 </div>
                                 <div class="forms" >
                                    <input type="password" placeholder="Confirm Password" name="confirm_password" id="cofpassword" class="form-control"><span id="passwordstrengths"></span>
                                 </div>
                                 <div class="forms">
                                    <select name="status" id="user_err" class="form-control">
                                       <option selected="true" disabled>Userstatus</option>
                                       <option value="0">Active</option>
                                       <option value="1">Inactive</option>
                                    </select>
                                    <span id="user_status"></span>
                                 </div>
                                 <div class="forms">
                                    <select name="user_admin" id="user_level_error" class="form-control">
                                       <option selected="true" disabled>User Level</option>
                                       <option value="0">Admin</option>
                                       <option value="1">User</option>
                                       <option value="2">Sales</option>
                                    </select>
                                    <span id="user_level"></span>
                                 </div>
                              </div>
                              <!-- Change Password field -->
                           </div>
                        </div>
                     </div>
                     <!-- END -->
                     <div class="setting">
                        <div class="text-align">
                           <button type="submit" class="btn  btn-color FiHD-secondarybg" id="btnSubmit" value="Validate">Save</button>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
   <!-- End of User Profile -->
   </form>
   <!-- END -->
   </div>
   </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>   
<script type="text/javascript">
    
    // to Stop User from Copy
    $('#full_name').bind('copy paste',function(e) {
    e.preventDefault(); return false; 
    });

    $('#full_name').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z ]*$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        $("#errmsg").hide();
        return true;
    }
    else
    {
    $("#errmsg").html("Alphabets only").show();
    $('#errmsg').css('color', 'red');
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
        $('#email_errmsg').html("Please enter Vaild Email ID").show();
        $('#email_errmsg').css('color', 'red');

    }else{
        $.ajax({
           type: "POST",
                url: "<?= site_url('Users/check_user_email_exists') ?>",
                async : false,
                data:{'email_id':value,'reqtype':'email_user_id'},
                success : function(data){
                    if (data == 'Unauthorized') {
                        $(this).css('color', 'red');
                        $('#email_errmsg').html("This EmailID is already exists. Please Choose another one").show();
                        $('#email_errmsg').css('color', 'red');
                    }else{
                        $('#email_address').css('color', '#000');
                        $("#email_errmsg").hide();
                    }
               }
        });
    }
});
</script>
<script type="text/javascript">
    $(function () {
        $("#txtPassword").bind("keyup", function () {
            //TextBox left blank.
            if ($(this).val().length <= 5) {
                $("#password_strength").html("Minimum 5 Character Required");
                $("#password_strength").css("color", "red");
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
         var full_name = $('#full_name').val();
         var email_address = $('#email_address').val();
         var newpassword = $('#txtPassword').val();
         var cofpassword = $('#cofpassword').val();
         if (full_name == '') {
            $('#errmsg').css('color', 'red');
            $('#errmsg').html("Full Name is required").show();
            return false;
         }else{
            $('#errmsg').hide();
         }
         if (email_address == '') {
            $('#email_errmsg').css('color', 'red');
            $('#email_errmsg').html("Email ID is required").show();
            return false;
         }else if(email_address != ''){
            var valid = validateEmail(email_address);
            if (!valid) {
                $('#email_errmsg').css('color', 'red');
                $('#email_errmsg').html("Please Enter Vaild Email ID").show();
                return false;
            }
         }else{
            $('#email_errmsg').hide();
         }

         if (newpassword != '' || cofpassword != '') {
            if (newpassword != cofpassword) {
               $('#passwordstrengths').css('color', 'red');
               $('#passwordstrengths').html("New Password & Confirm Password does not match").show();
               return false;
            }
         }else{
            $('#passwordstrengths').hide();
         }
         var user_err = $("#user_err").val();
         if (user_err == "" || user_err == null) {
            //If the "Please Select" option is selected display error.
            $('#user_status').css('color', 'red');
            $('#user_status').html("User Status is required").show();
            return false;
         }else{
            $('#user_status').hide();
         }
         var user_level_error = $("#user_level_error").val();
         if (user_level_error == "" || user_level_error == null) {
            //If the "Please Select" option is selected display error.
            $('#user_level').css('color', 'red');
            $('#user_level').html("User Level is required").show();
            return false;
         }else{
            $('#user_level').hide();
         }
         
   });
</script>
<script type="text/javascript">
    $(function () {
        $("#cofpassword").keyup(function () {
            var password = $("#txtPassword").val();
            var confirmPassword = $("#cofpassword").val();

            if (password != confirmPassword) {
                $('#passwordstrengths').css('color', 'red');
                $('#passwordstrengths').html("Password does not match").show(); 
            }else{
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
