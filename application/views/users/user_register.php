<!-- Main section-->
<section class="FiHD-analytics">
  <!-- Page content-->
  <div class="content-wrapper">
    
    <!-- START radial charts-->
    <div class="row ">

        <div class="col-lg-12 ">
          <!-- START widget-->

          <div class="panels marginbtm-10">
            <div class="main-heading">
             
                <span class="fontcolor-primary text-bold" style="font-size:18px;">Users </span >            
                <div class="float-right tools">
                	<?php $users_data_count = count($users_data); if($users_data_count <= 5){ ?>
                    <a class="user-icons" href="<?= site_url('Users/adduser') ?>"><img src="<?= site_url('cms-assets/img/svg-icon/add.png') ?>"  title="adduser"></a>
                    <?php } ?>
                    <a href="#"><img src="<?= site_url('cms-assets/img/svg-icon/question.png') ?>" data-toggle="tooltip" title="Knowledge Base" class="float-right img-height marginleft" alt="" ></a>      
                </div>
            </div>
          </div>

          <!-- Tab panel -->
          <div class="col-lg-12 padd-0 marginbtm-10">
            <div class="panels marginbtm0">
              <div class="FiHD-analytics-panel">

                <!-- Page Panel -->
                <div id="FiHD-analytics-page">
                  
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                
                                <th>Name</th>
                                <th>Email</th>
                                <th>User status</th>
                                <th>Access Level</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            if (!empty($users_data)) {
                            $i = 1;
                            foreach ($users_data as $value) {
                            if($_SESSION['Usr_Id'] != $value['id']) { ?>
                            <tr>
                                <td><?php echo $value['full_name']; ?></td>
                                <td><?php echo $value['email_id']; ?></td>
                                <td><?php if($value['status'] == 0){ echo "Active"; }else if($value['status'] == 1){ echo "InActive"; }else{ echo "<span style='color: red;'>Email-ID not Verified </span>";}  ?></td>
                                <td><?php if($value['user_admin'] == 0){ echo "Admin"; }else if($value['user_admin'] == 1){ echo "User"; }else{ echo "Sales";}  ?></td>
                                <td class="user-icons">
                                  <a href="<?= site_url('Users/add_edit/'.$value['id'].'') ?>" title="Edit"><img src="<?= site_url('cms-assets/img/svg-icon/edit.png') ?>" alt="" class="img-height cursor"></a>
                                  <a onclick="return DeleteUser(<?php echo $value['id']; ?>);" title="Delete"><img src="<?= site_url('cms-assets/img/svg-icon/delete.png') ?>" alt="" class="img-height cursor"></a>
                                </td>
                            </tr>
                            <?php $i++; } } } ?>
                        </tbody>
                    </table>
                  
                </div>
                <!-- Enf of page panel -->
                
</section>
<script src="<?= site_url('cms-assets/vendor/jquery/dist/jquery.js') ?>"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

function DeleteUser(remove_user_id){
   swal({
     title: "Are you sure?",
     text: "Once deleted, you will not be able to recover this User!",
     icon: "warning",
     buttons: true,
     dangerMode: true,
   })
   .then((willDelete) => {
     if (willDelete) {
       $.ajax({
       type: "POST",
            url: "<?= site_url('Users/add_delete') ?>",
            async : false,
            data:{'remove_user_id':remove_user_id,'reqtype':'delete_user'},
            success : function(data){
             console.log(data);
           }
       });
       swal("Poof! User has been deleted!", {
         icon: "success", 
       });
       myVar = setTimeout(alertFunc, 2000);
       
     } else {
       swal("User is safe!"); 
     }
   });
}

function alertFunc() {
   window.location.reload(true);
}
   
</script>
<script type="text/javascript">
$(document).ready(function() {
  $('#example').DataTable();
} );
</script>