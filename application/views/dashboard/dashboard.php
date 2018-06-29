<style type="text/css">
.dataTables_wrapper{
	padding: 0 30px;
}
.tag-suggestion::-webkit-scrollbar {
        width: 0.5em !important;
    }
    .tag-suggestion::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 0px rgba(0,0,0,0) !important;
    }
    .tag-suggestion::-webkit-scrollbar-thumb {
        background-color: #2d3e50 !important;
        outline: 0px solid white !important;
    }
   .emp_desc_nemp_img{
      margin: 0 0 189px;
     }
   .emp_desc_nemp_img_pic{
      position: relative;
      display: block;
      height: 240px;
      width: 360px;
      overflow: hidden;
   }
  .item{
    position: relative;
    height: 406px;
    width: 100%; 
  }
  .item img
  {
    max-height: 400px;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    max-width: 100%;
  }
  .dataTables_length,
    .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate{
        display:none;
    }
  table.dataTable.no-footer {
    border-bottom: none;
}
  table tr {
            border-bottom: 1px solid #000;
        }
   .item1{
   	    display: inline-block;
    background: #fff;
    margin: 0 0 1.5em;
    /* padding-bottom: 50px; */
    width: 100%;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-shadow: 2px 2px 4px 0 #ccc;
    padding-bottom: 30px;
    text-align: center;
   }
   .item1 .content1{
   	    padding: 5px 30px 0 30px;
    margin: 5px;
    font-size: 15px;
    font-weight: 100;
    line-height: 24px;
    /* color: #414141; */
    /* letter-spacing: 0.03em; */
    text-align: left;
   }
   .item1 img{
   	    max-width: 70%;
    padding: 20px 40px 30 40px;
    margin-top: 20px;
   }
</style>
<section id="ajax_call">
  <!-- Page content-->
  <div class="content-wrapper">
    
    <!-- START radial charts-->
    <div class="row ">
    	 <div class="col-lg-4">
    	 	 <div class="col-md-12 padd-0  marginbtm-10 ">
    	 	 	<div class="panels marginbtm0 ">
                 <div class="FiHD-analytics-panel" style="padding-bottom: 10px;">
             <h4 class="dashboard-heading"><img src="<?= site_url('cms-assets/img/Facebookicon.png') ?>" style="margin-bottom: 3px;">&nbsp;&nbsp;Facebook </h4>
                 	<div id="FiHD-analytics-page" class="tag-suggestion" style="height:300px;overflow-y: scroll;">
                                <table id="Facebook_table" class="display" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      
                                      <th style="width:70%;">Metrics</th>
                                      <th style="width:30%;">Values</th>
                                      
                                  </tr>
                              </thead>
                              <tbody>

                                  <tr>
                                      <td><img src="<?= site_url('cms-assets/img/Likesicon.png') ?>" style="width:16px;margin-right: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Likes</td>
                                      <td><?php echo (!empty($facebook_page_summary['fan_count']) ? $facebook_page_summary['fan_count'] : ''); ?></td>
                                  </tr>
                                  
                                  <tr>
                                      <td><img src="<?= site_url('cms-assets/img/Postsicon.png') ?>" style="width:16px;margin-right: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Posts</td>
                                      <td><?php echo (!empty(count($facebook_page_summary['posts'])) ? count($facebook_page_summary['posts']) : ''); ?></td>
                                  </tr>
                      
                                   <tr>
                                      <td><img src="<?= site_url('cms-assets/img/NewFansIcon.png') ?>" style="width:16px;margin-right: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;New Fans</td>
                                      <td><?php echo (!empty($facebook_page_summary['new_like_count']) ? $facebook_page_summary['new_like_count'] : ''); ?></td>
                                  </tr>
                                   <tr>
                                      <td><img src="<?= site_url('cms-assets/img/TalkingAbout.png') ?>" style="width:16px;margin-right: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Talking About</td>
                                      <td><?php echo (!empty($facebook_page_summary['talking_about_count']) ? $facebook_page_summary['talking_about_count'] : ''); ?></td>
                                  </tr>
                                  <tr>
                                      <td><img src="<?= site_url('cms-assets/img/UnreadMessageIcon.png') ?>" style="width:16px;margin-right: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Un-read Message</td>
                                      <td><?php echo (!empty($facebook_page_summary['unread_message_count']) ? $facebook_page_summary['unread_message_count'] : ''); ?></td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                 </div>
             </div>
    	 	 </div>
    	 </div>
    	  <div class="col-lg-4">
    	 	 <div class="col-md-12 padd-0  marginbtm-10 ">
    	 	 	<div class="panels marginbtm0 ">
                 <div class="FiHD-analytics-panel" style="padding-bottom: 10px;">
                 	<h4 class="dashboard-heading"><img src="<?= site_url('cms-assets/img/Twittericon.png') ?>" style="margin-bottom: 3px;">&nbsp;&nbsp;Twitter</h4>
                 	<div id="FiHD-analytics-page" class="tag-suggestion" style="height:300px;overflow-y: scroll;">
                                <table id="Twitter_table" class="display" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      
                                      <th style="width:70%;">Metrics</th>
                                      <th style="width:30%;">Values</th>
                                      
                                  </tr>
                              </thead>
                              <tbody>

                                  <tr>
                                      <td><img src="<?= site_url('cms-assets/img/Likesicon.png') ?>" style="width:16px;margin-right: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Likes</td>
                                      <td><?php if (!empty($twitter_user_profile)) { ?><?php echo $twitter_user_profile['favourites_count']; ?><?php } ?></td>
                                  </tr>
                                  
                                  <tr>
                                      <td><img src="<?= site_url('cms-assets/img/TweetsIcon.png') ?>" style="width:16px;margin-right: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Tweets</td>
                                      <td><?php if (!empty($twitter_user_profile)) { ?><?php echo $twitter_user_profile['statuses_count']; ?><?php } ?></td>
                                  </tr>
                      
                                   <tr>
                                      <td><img src="<?= site_url('cms-assets/img/Followicon.png') ?>" style="width:16px;margin-right: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Follower</td>
                                      <td><?php if (!empty($twitter_user_profile)) { ?><?php echo $twitter_user_profile['followers_count']; ?><?php } ?></td>
                                  </tr>
                                   <tr>
                                      <td><img src="<?= site_url('cms-assets/img/Followingicon.png') ?>" style="width:16px;margin-right: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Following</td>
                                      <td><?php if (!empty($twitter_user_profile)) { ?><?php echo $twitter_user_profile['friends_count']; ?><?php } ?></td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                 </div>
             </div>
    	 	 </div>
    	 </div>
    	 <div class="col-lg-4">
    	 	 <div class="col-md-12 padd-0  marginbtm-10 ">
    	 	 	<div class="panels marginbtm0 ">
                 <div class="FiHD-analytics-panel" style="padding-bottom: 10px;">
                 	<h4 class="dashboard-heading"><img src="<?= site_url('cms-assets/img/LinkedInicon.png') ?>" style="margin-bottom: 3px;">&nbsp;&nbsp;Linked_In</h4>
                 	<div id="FiHD-analytics-page" class="tag-suggestion" style="height:300px;overflow-y: scroll;">
                                <table id="Linked_In_table" class="display" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      
                                      <th style="width:70%;">Metrics</th>
                                      <th style="width:30%;">Values</th>
                                      
                                  </tr>
                              </thead>
                              <tbody>

                                  <tr>
                                      <td><img src="<?= site_url('cms-assets/img/Likesicon.png') ?>" style="width:16px;margin-right: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Connections</td>
                                      <td><?php echo (!empty($linkedin_followers) ? $linkedin_followers : ''); ?></td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                 </div>
             </div>
    	 	 </div>
    	 </div>
      
       
        
    </div>

    <!-- START radial charts-->
    <div class="row ">
     <div class="col-lg-4 padd-10">

	        <div class="min-height" style="height: 395px;overflow-x: hidden;">
          <?php if(!empty($scheduled_social_board)){ ?>        
            <div class="panels marginbtm-6">
	            <div class="row">
	              <div class="col-md-12 ">                    
	                <div class="dashboard-logs">
  	                <div class="col-lg-4" style="padding-right: 0px;">
                      <?php if (!empty($scheduled_social_board['image_name'])) { ?>
  	                  <img src="<?php echo $scheduled_social_board['image_name']; ?>" style="width:100%;">
                      <?php }else{  ?>
  	             		  <img src="<?= site_url('cms-assets/img/img.png') ?>" style="width:100%;">
                      <?php } ?>
                    </div>
  	                <div class="col-lg-8">
  	                		<span class="fontsize12"> <?php echo (!empty($scheduled_social_board['description']) ? $scheduled_social_board['description'] : ''); ?> </span>
  	            		</div>
  	            		<hr />
  	            		<div class="col-lg-12" style="text-align: right;">
  	            			<p class="text-bold fontcolor-primary fontsize12" style="text-align:right; float:right;">
  	                  		<span class="fontsize12"><?php echo date('d M, Y',strtotime($scheduled_social_board['is_scheduled_date'])); ?> | </span>
  	                  		<span class="fontsize12"><?php echo date('h:i:s',strtotime($scheduled_social_board['is_scheduled_date'])); ?></span><br/>
  	                  		<span style="font-weight:bold;">by <?php echo (!empty($scheduled_social_board['added_by']) ? $scheduled_social_board['added_by'] : ''); ?></span>
  	                		</p>
  	                		<p style="float:left; opacity: 0.6; margin-top: 2px;">
                          <?php if (strpos($scheduled_social_board['social_shared'], 'facebook_page') !== false || strpos($scheduled_social_board['social_shared'], 'facebook_profile') !== false) { ?>
  	                 			<img src="<?= site_url('cms-assets/img/face2.png') ?>" style="width:12px; margin-right: 5px;">
                          <?php }if (strpos($scheduled_social_board['social_shared'], 'twitter') !== false) { ?>
                       		<img src="<?= site_url('cms-assets/img/tw.png') ?>" style="width:12px; margin-right: 7px;">
                          <?php }if (strpos($scheduled_social_board['social_shared'], 'linkedin_page') !== false || strpos($scheduled_social_board['social_shared'], 'linkedin_profile') !== false) { ?>	
                       		<img src="<?= site_url('cms-assets/img/in.png') ?>" style="width:12px;">
                          <?php } ?>
                       	</p>
  	            		</div>
	               </div>                   
	              </div>
	            </div>             
          	</div>
	      	  <?php }else{ ?>
            <div class="panels marginbtm-6">
              <div class="row">
                <div class="col-md-12 ">                    
                  <div class="dashboard-logs">
                      <span class="fontsize12">No data available</span>                   
                  </div>                   
                </div>
              </div>
            </div>
          <?php } ?>
	        </div>
	        <!-- Reminder Set details End  -->
       </div>
      <div class="col-lg-4 padd-10">
          <!-- START List group-->
        <?php if (!empty($marketing_social_board)) { ?>
        <div class="panels max-height">
          	<div class="masonry">
		        <div class="item1">
		            <p class="content1">
                    <?php echo (!empty($marketing_social_board['description']) ? $marketing_social_board['description'] : ''); ?> 
                </p>
                <?php if (!empty($marketing_social_board['image_name'])) { ?>
		            <img src="<?php echo $marketing_social_board['image_name']; ?>"/>
                <?php } ?>
		        </div>
	       	</div>
        </div>
      <?php }else{ ?>
        <div class="panels marginbtm-6">
            <div class="row">
              <div class="col-md-12 ">                    
                <div class="dashboard-logs">
                    <span class="fontsize12">No data available</span>                   
                </div>                   
              </div>
            </div>
        </div>
      <?php } ?>
            <!-- END List group-->
      </div>
      <div class="col-lg-4 padd-10 positionrelative">
        <!-- START -->
        <div class="min-height opacity">
          <h1 style="position:  absolute;text-align:center;top: 0;bottom:  0;width:  100%;margin:  auto;vertical-align:  middle;height: 60px;font-weight: 700;text-transform: uppercase;">Coming <br> Soon</h1>
          <div class="panels marginbtm-6">
            <div class="row">
              <div class="col-md-12 ">                    
                <div class="dashboard-logs">
                  <span class="fontsize12">New Follow Added <span class="text-bold fontcolor-primary">By Sarfaraz</span></span>
                  <span class="float-right fontsize12">24 Feb 2018</span> <br>
                  <span class="text-bold fontcolor-primary" >by Admin</span>
                  <span class="float-right fontsize12">14:20:12</span>
                </div>                   
              </div>
            </div>
              <!-- END -->
          </div>
          <div class="panels marginbtm-6">
            <div class="row">
              <div class="col-md-12 ">                    
                <div class="dashboard-logs">
                  <span class="fontsize12">New Follow Added <span class="text-bold fontcolor-primary">By Sarfaraz</span></span>
                  <span class="float-right fontsize12">24 Feb 2018</span> <br>
                  <span class="text-bold fontcolor-primary" >by Admin</span>
                  <span class="float-right fontsize12">14:20:12</span>
                </div>                   
              </div>
            </div>
              <!-- END -->
          </div>
          <div class="panels marginbtm-6">
            <div class="row">
              <div class="col-md-12 ">                    
                <div class="dashboard-logs">
                  <span class="fontsize12">New Follow Added <span class="text-bold fontcolor-primary">By Sarfaraz</span></span>
                  <span class="float-right fontsize12">24 Feb 2018</span> <br>
                  <span class="text-bold fontcolor-primary" >by Admin</span>
                  <span class="float-right fontsize12">14:20:12</span>

                </div>                   
              </div>
            </div>
              <!-- END -->
          </div>
          <div class="panels marginbtm-6">
            <div class="row">
              <div class="col-md-12 ">                    
                <div class="dashboard-logs">
                  <span class="fontsize12">New Follow Added <span class="text-bold fontcolor-primary">By Sarfaraz</span></span>
                  <span class="float-right fontsize12">24 Feb 2018</span> <br>
                  <span class="text-bold fontcolor-primary" >by Admin</span>
                  <span class="float-right fontsize12">14:20:12</span>
                </div>                   
              </div>
            </div>
              <!-- END -->
          </div>

          <div class="panels marginbtm-6">
            <div class="row">
              <div class="col-md-12 ">                    
                <div class="dashboard-logs">
                  <span class="fontsize12">New Follow Added <span class="text-bold fontcolor-primary">By Sarfaraz</span></span>
                  <span class="float-right fontsize12">24 Feb 2018</span> <br>
                  <span class="text-bold fontcolor-primary" >by Admin</span>
                  <span class="float-right fontsize12">14:20:12</span>
                </div>                   
              </div>
            </div>
              <!-- END -->
          </div>
          
        </div>
      </div>
    </div>
  </div>
</section>
<script src="<?= site_url('cms-assets/vendor/jquery/dist/jquery.js') ?>"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#Linked_In_table').DataTable();
  $('#Twitter_table').DataTable();
  $('#Facebook_table').DataTable();
  event.preventDefault();
  $.ajax({ url: "<?= site_url('Dashboard/index') ?>",
      type: 'POST',
      data: {req_type:'social_analytics'},
      success: function(data){
         $("footer").remove();
         $('#ajax_call').html(data);
  }});
});
</script>